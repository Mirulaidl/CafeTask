<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Kafe') }}</title>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700|fraunces:500,600,700&display=swap" rel="stylesheet" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen antialiased">
  @include('layouts.navigation')
  @isset($header)
    <header class="mx-auto max-w-6xl px-4 pt-8 sm:px-6">{{ $header }}</header>
  @endisset
  <main class="pb-16">{{ $slot }}</main>
</body>
</html>
