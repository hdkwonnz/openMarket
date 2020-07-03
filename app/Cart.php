<?php

// https://www.youtube.com/watch?v=4J939dDUH4M&list=PL55RiY5tL51qUXDyBqx0mKVOhLNFwwxvH&index=9

namespace App;

use Illuminate\Support\Arr;

class Cart
{
    public $items = null;
    public $countOfItems = 0;

    public function __construct($oldCart)
    {
        if ($oldCart){
            $this->items = $oldCart->items;
            $this->countOfItems = count($this->items);
        }
    }

    public function change($item, $id)
    {
        // $storedItem = ['qty' => $item['qty'], 'price' => $item['price'], 'name' => $item['name'], 'productId' => $item['productId']];
        $storedItem =
                    [
                        'qty' => $item['qty'],
                        'price' => $item['price'],
                        'salePrice' => $item['salePrice'],
                        'saleRate' => $item['saleRate'],
                        'name' => $item['name'],
                        'productId' => $item['productId'],
                        'imagePath' => $item['imagePath']
                    ];

        if ($this->items){
            if (array_key_exists($id, $this->items)){
                $this->items[$id] = $storedItem;
            }
        }
    }

    public function delete($id)
    {
        if ($this->items){
            Arr::forget($this->items,$this->items[$id]);
            $this->countOfItems = count($this->items);
        }
    }

    public function add($item, $id)
    {
        // $storedItem = ['qty' => $item['qty'], 'price' => $item['price'], 'name' => $item['name'], 'productId' => $item['productId']];
        $storedItem =
                    [
                        'qty' => $item['qty'],
                        'price' => $item['price'],
                        'salePrice' => $item['salePrice'],
                        'saleRate' => $item['saleRate'],
                        'name' => $item['name'],
                        'productId' => $item['productId'],
                        'imagePath' => $item['imagePath']
                    ];

        if ($this->items){
            if (array_key_exists($id, $this->items)){
                $storedItem = $this->items[$id];
            }
        }

        $this->items[$id] = $storedItem;
        $this->countOfItems = count($this->items);
    }

    ////////DO NOT DELETE BELOW => ORIGINAL CODE FROM YOUTUBE////////////////////////////////////////
    ////https://www.youtube.com/watch?v=4J939dDUH4M&list=PL55RiY5tL51qUXDyBqx0mKVOhLNFwwxvH&index=9
    // public $items = null;
    // public $totalQty = 0;
    // public $totalPrice = 0;

    // public function __construct($oldCart)
    // {
    //     if ($oldCart){
    //         $this->items = $oldCart->items;
    //         $this->totalQty = $oldCart->totalQty;
    //         $this->totalPrice = $oldCart->totalPrice;
    //     }
    // }

    // public function add($item, $id)
    // {
    //     $storedItem = ['qty' => 0, 'price' => $item->price, 'item' => $item];
    //     if ($this->items){
    //         if (array_key_exists($id, $this->items)){
    //             $storedItem = $this->items[$id];
    //         }
    //     }
    //     $storedItem['qty']++;
    //     $storedItem['price'] = $item['price'] * $storedItem['qty'];
    //     $this->items[$id] = $storedItem;
    //     $this->totalQty++;
    //     $this->totalPrice += $item->price;
    // }
}
