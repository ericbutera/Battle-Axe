<?php
class baxe_Util_File {

    /**
     * Sanitize a wild filename from an untrusted source into something that is
     * safe for use.
     *
     * TODO iconv("UTF-8", "ASCII//TRANSLIT", $file);
     *
     * @param string $file
     * @return string
     */
    public function sanitize($file) {
        $ext = strrchr($file, ".");
        if (false !== $ext) {
            $name = substr($file, 0, strlen($file)-strlen($ext));
            $name = baxe_Util_PurdyString::generate($name);
            $ext  = baxe_Util_PurdyString::generate(trim($ext, "."));
            return $name .".". $ext;
        }

        return baxe_Util_PurdyString::generate($file);
    }


    /**
     * Make sure a given filename does not exist for the path.
     *
     * @param string $path Filesystem path to where the file should reside
     * @param string $filename Filename that should not exist
     * @return string Unique filename
     */
    public static function unique($path, $filename) {
        $ext = strrchr($filename, '.');
        if (false !== $ext) {
            $base = substr($filename, 0, -strlen($ext));
        } else {
            $base = $filename;
        }

        $attempt  = $base . $ext;
        $inc      = 1;

        while (file_exists($path . DIRECTORY_SEPARATOR . $attempt)) {
            $attempt = $base .'-'. $inc . $ext;
            ++$inc;
        }

        return $attempt;
    }

}
