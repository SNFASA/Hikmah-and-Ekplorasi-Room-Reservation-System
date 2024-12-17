<?php

if (!function_exists('getAllRoomTypes')) {
    function getAllRoomTypes()
    {
        return \App\Models\Room::distinct()->pluck('type_room');
    }
}
