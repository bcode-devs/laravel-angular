@extends('auth::errors.layout')

@section('title', 'Login Error')

@section('message', __('validation.unique', ['attribute'=>'Email']))
