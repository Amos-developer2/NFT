<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nft;

class NftSeeder extends Seeder
{
    public function run()
    {
        $nfts = [
            ['CryptoPunk #1', 'cryptopunk1.png', '#f5f5f5', 100.00, 'Legendary'],
            ['Bored Ape #2', 'boredape2.png', '#ffe4b5', 80.00, 'Epic'],
            ['Cool Cat #3', 'coolcat3.png', '#e0ffff', 50.00, 'Rare'],
            ['Doodle #4', 'doodle4.png', '#ffb6c1', 60.00, 'Epic'],
            ['Azuki #5', 'azuki5.png', '#d3d3d3', 90.00, 'Legendary'],
            ['Mutant Ape #6', 'mutantape6.png', '#fafad2', 70.00, 'Rare'],
            ['Goblin #7', 'goblin7.png', '#98fb98', 30.00, 'Common'],
            ['Moonbird #8', 'moonbird8.png', '#add8e6', 120.00, 'Legendary'],
        ];
        $publicPath = public_path('images');
        if (!is_dir($publicPath)) {
            mkdir($publicPath, 0777, true);
        }
        foreach ($nfts as $i => $nft) {
            $imgPath = $publicPath . DIRECTORY_SEPARATOR . $nft[1];
            if (!file_exists($imgPath)) {
                $imgData = @file_get_contents('https://placehold.co/300x300?text=' . urlencode(pathinfo($nft[1], PATHINFO_FILENAME)));
                if ($imgData) {
                    file_put_contents($imgPath, $imgData);
                }
            }
            Nft::create([
                'name' => $nft[0],
                'image' => '/images/' . $nft[1],
                'background' => $nft[2],
                'value' => $nft[3],
                'rarity' => $nft[4],
            ]);
        }
    }
}
