<?php
namespace App\Libraries\Tb;
class Tools {
    public static function aspectRatio ($width, $height) {
        // 最大公約数をユークリッドの互除法により求める
        // 幅、高さを最大公約数で割った値がアスペクト比となる

        $a = max ($width, $height);
        $b = min ($width, $height);

        while (($r = $a % $b) !== 0) { $a = $b; $b = $r; }

        return (['width' => $width / $b, 'height' => $height / $b]);
    }
}
?>