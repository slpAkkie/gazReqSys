@extends('templates.httpError')

@section('title', 'Ошибка в данных')
@section('code', '422')
@section('message', 'Данные которые были переданы не прошли проверку')
