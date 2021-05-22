<?php

function kbFromBytes($bytes)
{
    return round($bytes / 1024);
}
//
//function optional(string $key, $data,$default=null){
//
//    switch (gettype($data)){
//        case 'array':
//        return array_key_exists($key,$data)?$data[$key]:$default;
//        break;
//
//        case 'object':
//            return $data->$key;
//            break;
//        default:
//            return $default;
//    }
//
//
//
//
//}