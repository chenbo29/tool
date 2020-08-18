<?php


namespace chenbo29\Tool;


class Star
{
    public function fontawesome(int $number, string $color) {
        $data = [];
        if ($number < 5) {
            $data = [
                sprintf('<span style="color: %s"><i class="far fa-star"></i></span>', $color)
            ];
        } else if ($number < 10) {
            $data = [
                sprintf('<span style="color: %s"><i class="fas fa-star-half-alt"></i></span>', $color)
            ];
        } else if ($number < 15) {
            $data = [
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color)
            ];
        } else if ($number < 20) {
            $data = [
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color),
                sprintf('<span style="color: %s"><i class="fas fa-star-half-alt"></i></span>', $color)
            ];
        } else if ($number < 25) {
            $data = [
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color),
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color),
            ];
        } else if ($number < 30) {
            $data = [
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color),
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color),
                sprintf('<span style="color: %s"><i class="fas fa-star-half-alt"></i></span>', $color)
            ];
        } else if ($number < 35) {
            $data = [
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color),
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color),
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color),
            ];
        } else if ($number < 40) {
            $data = [
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color),
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color),
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color),
                sprintf('<span style="color: %s"><i class="fas fa-star-half-alt"></i></span>', $color)
            ];
        } else if ($number < 45) {
            $data = [
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color),
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color),
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color),
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color),
            ];
        } else if ($number < 50) {
            $data = [
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color),
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color),
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color),
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color),
                sprintf('<span style="color: %s"><i class="fas fa-star-half-alt"></i></span>', $color)
            ];
        } else {
            $data = [
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color),
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color),
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color),
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color),
                sprintf('<span style="color: %s"><i class="fas fa-star"></i></span>', $color),
            ];
        }

        while (count($data) < 5) {
            array_push($data, sprintf('<span style="color: %s"><i class="far fa-star"></i></span>', $color));
        }

        return $data;
    }
}