<?php

require_once './scripts/php/imageupload.php';

use PHPUnit\Framework\TestCase;

class ImageUploadTest extends TestCase {
    public function testGetImageFoldersReturnsArray() {
        $imageUpload = new ImageUpload('images/');
        $folders = $imageUpload->getImageFolders();
        $this->assertIsArray($folders);
    }
}
