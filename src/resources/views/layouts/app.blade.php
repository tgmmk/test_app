<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- 独自に追加したCSS -->
        <style>
            .org-drop-4{
                display:none;
            }
            .org-menu-4:hover +.org-drop-4{
                display:block !important;
            }
            .org-drop-4:hover{
                display:block !important;
            }
            .org-drop-3{
                display:none;
            }
            .org-menu-3:hover +.org-drop-3{
                display:block !important;
            }
            .org-drop-3:hover{
                display:block !important;
            }
            /* readonlyまたはdisabledでは入力線を非表示 */
            .readonly,.disabled{
                caret-color: transparent;
            }
            /* .header_title{
                padding-bottom:0 !important;
            } */
            /* 戻るボタンが右側にある場合の見出しレイアウト */
            .midashi_title{
                width:70% !important;
                display:inline-block !important;
            }
            /* 戻るボタン*/
            .modoru{
                width:20% !important;
                display:inline-block !important;
                text-align:right;
            }
            /*-------------------------
             送迎場所マスタここから
            -------------------------*/
            /**
            * @license
            * Copyright 2019 Google LLC. All Rights Reserved.
            * SPDX-License-Identifier: Apache-2.0
            */
            /**
            * Always set the map height explicitly to define the size of the div element
            * that contains the map. 
            */

            #geo_input_txt {/*input[type="text"]*/
                background-color: #fff;
                border: 0;
                border-radius: 2px;
                box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
                margin: 10px;
                padding: 0 0.5em;
                font: 400 18px Roboto, Arial, sans-serif;
                overflow: hidden;
                line-height: 40px;
                margin-right: 0;
                min-width: 25%;
            }

            .geo_button {/*input[type="button"]*/
                background-color: #fff;
                border: 0;
                border-radius: 2px;
                box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
                margin: 10px;
                padding: 0 0.5em;
                font: 400 18px Roboto, Arial, sans-serif;
                overflow: hidden;
                height: 40px;
                cursor: pointer;
                margin-left: 5px;
            }
            .geo_button:hover {
                background: rgb(235, 235, 235);
            }
            .geo_button.button-primary {
                background-color: #1a73e8;
                color: white;
            }
            .geo_button.button-primary:hover {
                background-color: #1765cc;
            }
            .geo_button.button-secondary {
                background-color: white;
                color: #1a73e8;
            }
            .geo_button.button-secondary:hover {
                background-color: #d2e3fc;
            }

            #response-container {
                background-color: #fff;
                border: 0;
                border-radius: 2px;
                box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
                margin: 10px;
                padding: 0 0.5em;
                font: 400 18px Roboto, Arial, sans-serif;
                overflow: hidden;
                overflow: auto;
                max-height: 50%;
                max-width: 90%;
                background-color: rgba(255, 255, 255, 0.95);
                font-size: small;
            }

            #instructions {
                background-color: #fff;
                border: 0;
                border-radius: 2px;
                box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
                margin: 10px;
                padding: 0 0.5em;
                font: 400 18px Roboto, Arial, sans-serif;
                overflow: hidden;
                padding: 1rem;
                font-size: medium;
            }
        </style>
        <!-- 独自に追加 -->
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css"><!-- テーブル並び替え用ライブラリ -->
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script><!-- テーブル並び替え用ライブラリ -->
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-sky-100">
            @include('layouts.navigation')
            <!-- セッションメッセージ ここから -->
            @if(session('flash_message_success'))
            <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
                <div id="dismiss-alert" class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 bg-teal-50 border border-teal-200 text-sm text-teal-800 rounded-lg p-4 dark:bg-teal-800/10 dark:border-teal-900 dark:text-teal-500" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                        <svg class="flex-shrink-0 size-4 text-blue-600 mt-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                        </div>
                        <div class="ms-2">
                        <div class="text-sm font-medium">
                            {{ session('flash_message_success') }}
                        </div>
                        </div>
                        <div class="ps-3 ms-auto">
                        <div class="-mx-1.5 -my-1.5">
                            <button type="button" class="inline-flex bg-teal-50 rounded-lg p-1.5 text-teal-500 hover:bg-teal-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-teal-50 focus:ring-teal-600 dark:bg-transparent dark:hover:bg-teal-800/50 dark:text-teal-600" data-hs-remove-element="#dismiss-alert">
                            <span class="sr-only">Dismiss</span>
                            <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                            </button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if(session('flash_message_error'))
            <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
                <div id="dismiss-alert2" class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 bg-red-50 border border-red-200 text-sm text-red-800 rounded-lg p-4 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                        <svg class="flex-shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>                        </div>
                        <div class="ms-2">
                        <div class="text-sm font-medium">
                            {!! session('flash_message_error') !!}
                        </div>
                        </div>
                        <div class="ps-3 ms-auto">
                        <div class="-mx-1.5 -my-1.5">
                            <button type="button" class="inline-flex bg-red-50 rounded-lg p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-50 focus:ring-red-600 dark:bg-transparent dark:hover:bg-teal-800/50 dark:text-red-600" data-hs-remove-element="#dismiss-alert2">
                            <span class="sr-only">Dismiss</span>
                            <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                            </button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <!-- セッションメッセージ ここまで -->

            <!-- Page Heading -->
            @if (isset($header))
                <!-- <header class="bg-white shadow"> -->
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                <!-- </header> -->
            @endif


            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
