<?php
/**
 * 画像をアップロード
 *
 * @access public
 * @author okutani
 * @package Class
 * @category Image Uploader
 */

namespace MyApp;

class ImageUploader {

    private $_imageFileName;
    private $_imageType;

    /**
     * アップロードの実行
     *
     * @access public
     */
    public function upload()
    {
        try {
            // error checkd
            $this->_validateUpload();
            // type check
            $ext = $this->_validateImageType();
            // save
            $savePath = $this->_save($ext);
            // create thumbnail
            $this->_createThumbnail($savePath);

            $_SESSION["success"] = "Upload Done!";
        } catch (\Exception $e) {
            $_SESSION["error"] = $e->getMessage();
            // exit;
        }
        // redirect
        header("Location: " .
            (empty($_SERVER["HTTPS"]) ? "http://" : "https://") .
            $_SERVER["HTTP_HOST"] .
            $_SERVER["REQUEST_URI"]);
        exit;
    }

    public function getResults()
    {
        $success = null;
        $error = null;
        if (isset($_SESSION["success"])) {
            $success = $_SESSION["success"];
            unset($_SESSION["success"]);
        }
        if (isset($_SESSION["error"])) {
            $error = $_SESSION["error"];
            unset($_SESSION["error"]);
        }
        return [$success, $error];
    }

    /**
     * 画像のゲッター
     *
     * @access public
     * @return array $images
     */
    public function getImages()
    {
        $images = [];
        $files = [];
        $imageDir = opendir(IMAGES_DIR);
        while (false !== ($file = readdir($imageDir))) {
            if ($file === "." || $file === "..") {
                continue;
            }
            $files[] = $file;
            if (file_exists(THUMBNAIL_DIR . "/" . $file)) {
                $images[] = basename(THUMBNAIL_DIR) . "/" . $file;
            } else {
                $images[] = basename(IMAGES_DIR) . "/" . $file;
            }
        }
        array_multisort($files, SORT_DESC, $images);
        return $images;
    }

    /**
     * サムネイル作成
     *
     * @access private
     * @param string $ext 拡張子
     */
    private function _createThumbnail($savePath)
    {
        $imageSize = getimagesize($savePath);
        $width = $imageSize[0];
        $height = $imageSize[1];
        if ($width > THUMBNAIL_WIDTH) {
            $this->_createThumbnailMain($savePath, $width, $height);
        }
    }

    /**
     * 拡張子を判別してサムネイル作成
     *
     * @access private
     * @param string $savePath
     * @param int $width
     * @param int $height
     */
    private function _createThumbnailMain($savePath, $width, $height)
    {
        // 画像の拡張子ごとにsrcImageの取得を分ける
        switch ($this->_imageType) {
            case IMAGETYPE_GIF:
                $srcImage = imagecreatefromgif($savePath);
                break;
            case IMAGETYPE_JPEG:
                $srcImage = imagecreatefromjpeg($savePath);
                break;
            case IMAGETYPE_PNG:
                $srcImage = imagecreatefrompng($savePath);
                break;
        }
        // サムネイル用の高さの取得
        $thumbHeight = round($height * THUMBNAIL_WIDTH / $width);
        $thumbImage = imagecreatetruecolor(THUMBNAIL_WIDTH, $thumbHeight);
        // 透過PNGをON
        if ($this->_imageType == IMAGETYPE_PNG) {
            //ブレンドモードを無効にする
            imagealphablending($thumbImage, false);
            //完全なアルファチャネル情報を保存するフラグをonにする
            imagesavealpha($thumbImage, true);
        }
        // 再サンプリングをおこなう
        imagecopyresampled($thumbImage, $srcImage, 0, 0, 0, 0, THUMBNAIL_WIDTH,
        $thumbHeight, $width, $height);
        // 画像の拡張子ごとに保存
        switch($this->_imageType) {
            case IMAGETYPE_GIF:
                imagegif($thumbImage, THUMBNAIL_DIR . "/" . $this->_imageFileName);
                break;
            case IMAGETYPE_JPEG:
                imagejpeg($thumbImage, THUMBNAIL_DIR . "/" . $this->_imageFileName);
                break;
            case IMAGETYPE_PNG:
                imagepng($thumbImage, THUMBNAIL_DIR . "/" . $this->_imageFileName);
                break;
        }

    }

    /**
     * 保存
     *
     * @access private
     * @param string $ext 拡張子
     */
    private function _save($ext)
    {
        $this->_imageFileName = sprintf(
            "%s_%s.%s",
            time(), // 現在時刻
            sha1(uniqid(mt_rand(), true)), // quniqidで一意なキー、sha1でハッシュ変換
            $ext // 拡張子
        );

        $savePath = IMAGES_DIR . "/" . $this->_imageFileName;
        // tmpディレクトリから本番ディレクトリに移動
        $res = move_uploaded_file($_FILES["image"]["tmp_name"], $savePath);
        if ($res === false) {
            throw new \Exception("Could not upload!");
        }

        return $savePath;
    }

    /**
     * 拡張子のバリデーション
     *
     * @access private
     * @return string 拡張子|エラー
     */
    private function _validateImageType()
    {
        $this->_imageType = exif_imagetype($_FILES["image"]["tmp_name"]);
        switch ($this->_imageType) {
            case IMAGETYPE_GIF:
                return "gif";
            case IMAGETYPE_JPEG:
                return "jpg";
            case IMAGETYPE_PNG:
                return "png";
            default:
                throw new \Exception("PNG/JPG/PNG only!");
        }
    }

    /**
     * アップロード時のバリデーション
     *
     * @access private
     * @return string true|エラー
     */
    private function _validateUpload()
    {
        if (!isset($_FILES["image"]) || !isset($_FILES["image"]["error"])) {
            throw new \Exception("Upload Error!");
        }

        switch($_FILES["image"]["error"]) {
            case UPLOAD_ERR_OK:
                return true;
            case UPLOAD_ERR_INI_SIZE: // php.iniで設定された上限
            case UPLOAD_ERR_FORM_SIZE: // フォームで設定された上限
                throw new \Exception("File too large!");
            default:
                throw new \Exception("Err: " . $_FILES["image"]["error"]);
        }

    }
}
