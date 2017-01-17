<?php

use PHPKitty\Template\FileSystemTemplate;
use PHPKitty\UserPermissions;

use PHPUnit\Framework\TestCase;

class FileSystemTemplateTest extends TestCase {
    static $DIR = 'test_templates';

    public function testFooContent() {
        $content = 'foo';
        self::writeFile('index.txt', $content);
        $twig = self::makeTwig('index.txt');
        $output = $twig->render('index.txt');
        $this->assertEquals($content, $output);
    }

    /**
     *  @throw \Exception
     */
    public function testTemplateNotFound() {
        $twig = self::makeTwig('index.txt');
        $twig->render('index.txt');
    }

    public static function setUpBeforeClass() {
        mkdir(self::$DIR);
    }

    public static function tearDownAfterClass() {
        self::recursiveRmDir(self::$DIR);
    }

    public static function makeTwig($file) {
        $template = new FileSystemTemplate(self::$DIR, $file);
        return $template->makeTwig(new UserPermissions([]));
    }

    public static function writeFile($file, $content) {
        file_put_contents(self::$DIR . DIRECTORY_SEPARATOR . $file, $content);
    }

    public static function recursiveRmDir($dir) {
        $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it,
                    RecursiveIteratorIterator::CHILD_FIRST);
        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dir);
    }
}