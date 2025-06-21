<?php
class ImageUpload {
    private $targetDir;
    private $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    private $maxFileSize = 5242880; // 5MB

    public function __construct($targetDir = 'images/') {
        $this->targetDir = $targetDir;
    }

    public function formSubmission() {
        if ($this->isSubmitted() && isset($_POST["upload"])) {
            $message = $this->uploadImage();
            echo "<script type=\"text/javascript\">
                    alert(\"$message\");
                    window.location = \"?view=admin-pagina\"
            </script>";
        }
    }
    
    private function uploadImage() {
        // Check if file was uploaded
        if (!isset($_FILES["imageFile"]) || $_FILES["imageFile"]["error"] !== UPLOAD_ERR_OK) {
            return "Error: " . $this->getUploadErrorMessage($_FILES["imageFile"]["error"]);
        }

        $file = $_FILES["imageFile"];
        $fileName = basename($file["name"]);
        $targetSubDir = $_POST["targetFolder"] ?? '';
        $targetPath = $this->targetDir . $targetSubDir . '/' . $fileName;
        
        // Check file size
        if ($file["size"] > $this->maxFileSize) {
            return "Error: File is too large (max 5MB).";
        }
        
        // Check file extension
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $this->allowedExtensions)) {
            return "Error: Only JPG, JPEG, PNG & GIF files are allowed.";
        }
        
        // Check if folder exists
        $uploadDir = $this->targetDir . $targetSubDir;
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                return "Error: Failed to create directory.";
            }
        }
        
        // Upload the file
        if (move_uploaded_file($file["tmp_name"], $targetPath)) {
            return "The file " . htmlspecialchars($fileName) . " has been uploaded.";
        } else {
            return "Error: There was an error uploading your file.";
        }
    }
    
    private function getUploadErrorMessage($errorCode) {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return "File is too large.";
            case UPLOAD_ERR_PARTIAL:
                return "File was only partially uploaded.";
            case UPLOAD_ERR_NO_FILE:
                return "No file was uploaded.";
            case UPLOAD_ERR_NO_TMP_DIR:
                return "Missing a temporary folder.";
            case UPLOAD_ERR_CANT_WRITE:
                return "Failed to write file to disk.";
            case UPLOAD_ERR_EXTENSION:
                return "A PHP extension stopped the file upload.";
            default:
                return "Unknown upload error.";
        }
    }

    public function isSubmitted() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    public function getImageFolders() {
        $folders = [];
        $baseDir = $this->targetDir;
        
        if (is_dir($baseDir)) {
            $dirs = scandir($baseDir);
            foreach ($dirs as $dir) {
                if ($dir != '.' && $dir != '..' && is_dir($baseDir . $dir)) {
                    $folders[] = $dir;
                }
            }
        }
        
        return $folders;
    }
}