<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    public function show(): View
    {
        return view('admin.index', [
            'title' => 'Admin Panel',
            'players' => Player::query()->orderBy('id')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.create', [
            'title' => 'Create Player',
            'id' => $this->getRandomId(),
        ]);
    }

    protected function getRandomId(): int
    {
        $ids = Player::all()->pluck('id');

        do{
            $id = fake()->unique()->randomNumber(nbDigits: 3);
            if (! $ids->contains($id)) {
                return $id;
            }
        } while(true);
    }

    public function update(int $id): View
    {
        return view('admin.update', [
            'title' => 'Update Player',
            'id' => $id,
        ]);
    }

    public function switch(int $id): RedirectResponse
    {
        $player = Player::find($id);

        $player->update([
            'alive' => ! $player->alive,
        ]);

        return back();
    }

    public function delete(int $id): RedirectResponse
    {
        $player = Player::find($id);

        $player->delete();

        return Redirect::route('admin');
    }

    public function store(Request $request, int $id): RedirectResponse
    {
        if (! $request->hasFile('picture')) {
            back();
        }

        $path = $request->file('picture');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = $this->scaleImageFileToBlob($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $player = Player::find($id);

        if (! $player) {
            Player::create([
                'id' => $id,
                'picture' => $base64,
                'alive' => true,
            ]);
        } else {
            $player->update([
                'picture' => $base64
            ]);
        }

        return Redirect::route('admin');
    }

    //https://www.php.net/manual/en/function.imagejpeg.php
    function scaleImageFileToBlob($file)
    {

        $max_width = 480;
        $max_height = 720;

        [$width, $height, $image_type] = getimagesize($file);

        $src = imagecreatefromjpeg($file);

        if ($width > $height) {
            [$width, $height] = [$height, $width];
            $src = imagerotate($src, 270, 0);
        }

        $x_ratio = $max_width / $width;
        $y_ratio = $max_height / $height;

        if( ($width <= $max_width) && ($height <= $max_height) ){
            $tn_width = $width;
            $tn_height = $height;
        }elseif (($x_ratio * $height) < $max_height){
            $tn_height = ceil($x_ratio * $height);
            $tn_width = $max_width;
        }else{
            $tn_width = ceil($y_ratio * $width);
            $tn_height = $max_height;
        }

        $tmp = imagecreatetruecolor($tn_width,$tn_height);

        /* Check if this image is PNG or GIF, then set if Transparent*/
        if(($image_type == 1) OR ($image_type==3))
        {
            imagealphablending($tmp, false);
            imagesavealpha($tmp,true);
            $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
            imagefilledrectangle($tmp, 0, 0, $tn_width, $tn_height, $transparent);
        }
        imagecopyresampled($tmp,$src,0,0,0,0,$tn_width, $tn_height,$width,$height);

        /*
         * imageXXX() only has two options, save as a file, or send to the browser.
         * It does not provide you the oppurtunity to manipulate the final GIF/JPG/PNG file stream
         * So I start the output buffering, use imageXXX() to output the data stream to the browser,
         * get the contents of the stream, and use clean to silently discard the buffered contents.
         */
        ob_start();

        switch ($image_type)
        {
            case 1: imagegif($tmp); break;
            case 2: imagejpeg($tmp, NULL, 100);  break; // best quality
            case 3: imagepng($tmp, NULL, 0); break; // no compression
            default: echo ''; break;
        }

        $final_image = ob_get_contents();

        ob_end_clean();

        return $final_image;
    }
}
