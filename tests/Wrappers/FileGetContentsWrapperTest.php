<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\Wrappers\FileGetContentsWrapper;
use PHPUnit\Framework\TestCase;

class FileGetContentsWrapperTest extends TestCase
{
    public function testFileGetContents(): void
    {
        $wrapper = $this->createMock(FileGetContentsWrapper::class);
        $wrapper->method('fileGetContents')->willReturn('Hello World!');

        $this->assertSame(
            expected: 'Hello World!',
            actual: $wrapper->fileGetContents('https://localhost'),
        );
    }
}
