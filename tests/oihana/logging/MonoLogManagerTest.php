<?php

namespace tests\oihana\logging;

use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\LineFormatter;
use Monolog\Level;

use Psr\Log\LoggerInterface;

use oihana\logging\enums\LoggerParam;
use oihana\logging\enums\MonoLogParam;
use oihana\logging\MonoLogManager;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class MonoLogManagerTest extends TestCase
{
    private string $dir;

    protected function setUp(): void
    {
        $this->dir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'oihana-monolog-' . uniqid() ;
        mkdir( $this->dir , 0o775 , true ) ;
    }

    protected function tearDown(): void
    {
        if ( is_dir( $this->dir ) )
        {
            foreach ( scandir( $this->dir ) as $file )
            {
                if ( $file !== '.' && $file !== '..' )
                {
                    @unlink( $this->dir . DIRECTORY_SEPARATOR . $file ) ;
                }
            }
            @rmdir( $this->dir ) ;
        }
    }

    public function testConstructorAppliesDefaultsAndInitOptions(): void
    {
        $manager = new MonoLogManager
        ([
            LoggerParam::DIRECTORY                       => $this->dir ,
            MonoLogParam::ALLOW_INLINE_LINE_BREAKS       => false ,
            MonoLogParam::BUBBLES                        => false ,
            MonoLogParam::DATE_FORMAT                    => 'Y-m-d' ,
            MonoLogParam::FILE_PERMISSIONS               => '0664' ,
            MonoLogParam::FORMAT                         => '%message%' ,
            MonoLogParam::INCLUDE_STACK_TRACES           => true ,
            MonoLogParam::IGNORE_EMPTY_CONTEXT_AND_EXTRA => false ,
            MonoLogParam::LEVEL                          => Level::Warning->value ,
            MonoLogParam::MAX_FILES                      => 7 ,
        ] , 'app' ) ;

        $this->assertFalse( $manager->allowInlineLineBreaks ) ;
        $this->assertFalse( $manager->bubbles ) ;
        $this->assertSame( 'Y-m-d' , $manager->dateFormat ) ;
        $this->assertSame( 0o664 , $manager->filePermissions ) ;
        $this->assertSame( '%message%' , $manager->format ) ;
        $this->assertTrue( $manager->includeStackTraces ) ;
        $this->assertFalse( $manager->ignoreEmptyContextAndExtra ) ;
        $this->assertSame( Level::Warning->value , $manager->level ) ;
        $this->assertSame( 7 , $manager->maxFiles ) ;
    }

    /**
     * Non-regression: building the manager without an explicit level must keep the
     * default Level::Debug enum, not intval() it (which warned and yielded 1).
     */
    /**
     * The file permissions, however they are given : the expected values are octal
     * literals, never computed by octdec() — the function the defect lived in.
     *
     * @return array<string, array{0:mixed, 1:int}>
     */
    public static function filePermissions(): array
    {
        return
        [
            'absent'                  => [ null    , 0o664 ] ,
            'an octal string'         => [ '0664'  , 0o664 ] ,
            'an octal integer'        => [ 0o664   , 0o664 ] ,
            'another octal string'    => [ '0640'  , 0o640 ] ,
            'another octal integer'   => [ 0o600   , 0o600 ] ,
        ] ;
    }

    #[DataProvider('filePermissions')]
    public function testFilePermissionsAreReadWhateverTheirForm( mixed $given , int $expected ): void
    {
        $init    = $given === null ? [] : [ MonoLogParam::FILE_PERMISSIONS => $given ] ;
        $manager = new MonoLogManager( $init ) ;

        $this->assertSame( $expected , $manager->filePermissions , sprintf( 'got 0%o' , $manager->filePermissions ) ) ;
    }

    public function testANewLogFileIsCreatedWithTheDefaultPermissions(): void
    {
        $manager = new MonoLogManager( [ LoggerParam::DIRECTORY => $this->dir ] , 'app' ) ;

        $logger = $manager->createLogger() ;
        $logger->info( 'written' ) ;

        restore_error_handler() ;
        restore_exception_handler() ;

        $files = glob( $this->dir . DIRECTORY_SEPARATOR . '*' ) ?: [] ;
        $this->assertCount( 1 , $files ) ;

        clearstatcache() ;
        $this->assertSame( '0664' , sprintf( '%04o' , fileperms( $files[ 0 ] ) & 0o777 ) ) ;
    }

    public function testDefaultLevelKeepsTheDebugEnumWithoutCoercion(): void
    {
        $manager = new MonoLogManager( [ LoggerParam::DIRECTORY => $this->dir ] ) ;
        $this->assertSame( Level::Debug , $manager->level ) ;
    }

    public function testExplicitIntegerLevelIsCoerced(): void
    {
        $manager = new MonoLogManager( [ MonoLogParam::LEVEL => '400' ] ) ;
        $this->assertSame( 400 , $manager->level ) ;
    }

    public function testCreateLoggerReturnsConfiguredLogger(): void
    {
        $manager = new MonoLogManager( [ LoggerParam::DIRECTORY => $this->dir ] , 'app' ) ;

        $logger = $manager->createLogger() ;

        // createLogger() registers global error/exception handlers via Monolog's
        // ErrorHandler; restore them so the test does not leak handler state.
        restore_error_handler() ;
        restore_exception_handler() ;

        $this->assertInstanceOf( LoggerInterface::class , $logger ) ;
    }

    public function testGetFormatterIsBuiltOnceAndCached(): void
    {
        $manager = new MonoLogManager( [ LoggerParam::DIRECTORY => $this->dir ] ) ;

        $formatter = $manager->getFormatter() ;

        $this->assertInstanceOf( LineFormatter::class , $formatter ) ;
        $this->assertInstanceOf( FormatterInterface::class , $formatter ) ;
        $this->assertSame( $formatter , $manager->getFormatter() ) ; // cached
    }
}
