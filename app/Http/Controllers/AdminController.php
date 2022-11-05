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

        return Redirect::route('admin');
    }

    public function delete(int $id): RedirectResponse
    {
        $player = Player::find($id);

        $player->delete();

        return Redirect::route('admin');
    }

    public function store(Request $request, int $id): RedirectResponse
    {
        $path = $request->file('picture');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
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
}
