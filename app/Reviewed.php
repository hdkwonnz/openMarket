<?php

namespace App;

use Cookie;

class Reviewed
{
    public function __construct()
    {

    }

    // https://www.256kilobytes.com/content/show/3282/laravel-php-how-to-make-a-recently-viewed-posts-widget
    // The actual function to call to push the current page into the "recently viewed posts"
    // cookie data. The only Laravel functionality here that isn't in plain PHP is the Laravel
    // cookie library:
    // https://laravel.com/docs/5.7/requests#cookies
    // Also \Request::url(), which gets the current URL:
    // https://laravel.com/docs/5.7/urls#accessing-the-current-url
    public function add($id, $imagePath)
    {
        // Configuration Variables
        $num_to_store     =    10; // If there are more than this many stored, delete the oldest one
        $minutes_to_store = 1440; // These cookies will automatically be forgotten after this number of minutes. 1440 is 24 hours.

        // Create an object with the data required to create the "Recently Viewed" widget
        $current_page["id"]       = $id;//current product id
        $current_page["url" ]     = $imagePath; //current image URL

        // Get the existing cookie data from the user
        $recent                  = Cookie::get('recently_viewed_content');

        // Since cookies must be strings, the data is stored as JSON.
        // Decode the data.
        // The second parameter, "[w]hen TRUE, returned objects will be
        // converted into associative arrays."
        $recent                  = json_decode($recent, TRUE);

        // If the URL already exists in the user's history, delete the older one
        // Note -- If there are multiple URLs for individual posts (GET variables, etc)
        // Possibly rework to include a unique post ID (or whatever)
        if ( $recent ) {
                foreach ( $recent as $key=>$val ) {
                        if ( $val["id"] == $current_page["id"])
                                unset( $recent[$key] );
                }
        }

        // Push the current page into the recently viewed posts array
        $recent[ time() ] = $current_page;

        // If more than $num_to_store elements, then delete everything except the newest $num_to_store
        if (sizeof($recent) > $num_to_store) {
                // These are already in the correct order, but would theoretically be logical to sort by key here.
                $recent = array_slice($recent, sizeof($recent) - $num_to_store, sizeof($recent), true);
        }

        // Queue the updated "recently viewed" list to update on the user's next page load
        // I.e., don't show the current page as "recently viewed" until they navigate away from it (or otherwise refresh the page)
        Cookie::queue('recently_viewed_content', json_encode($recent), $minutes_to_store);
    }
}
