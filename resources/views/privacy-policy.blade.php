<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    <!-- Styles -->
    <style>
        /* ! tailwindcss v3.2.4 | MIT License | https://tailwindcss.com */
        *, ::after, ::before {
            box-sizing: border-box;
            border-width: 0;
            border-style: solid;
            border-color: #e5e7eb
        }

        ::after, ::before {
            --tw-content: ''
        }

        html {
            line-height: 1.5;
            -webkit-text-size-adjust: 100%;
            -moz-tab-size: 4;
            tab-size: 4;
            font-family: Figtree, sans-serif;
            font-feature-settings: normal
        }

        body {
            margin: 0;
            line-height: inherit
        }

        hr {
            height: 0;
            color: inherit;
            border-top-width: 1px
        }

        abbr:where([title]) {
            -webkit-text-decoration: underline dotted;
            text-decoration: underline dotted
        }

        h1, h2, h3, h4, h5, h6 {
            font-size: inherit;
            font-weight: inherit
        }

        a {
            color: inherit;
            text-decoration: inherit
        }

        b, strong {
            font-weight: bolder
        }

        code, kbd, pre, samp {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 1em
        }

        small {
            font-size: 80%
        }

        sub, sup {
            font-size: 75%;
            line-height: 0;
            position: relative;
            vertical-align: baseline
        }

        sub {
            bottom: -.25em
        }

        sup {
            top: -.5em
        }

        table {
            text-indent: 0;
            border-color: inherit;
            border-collapse: collapse
        }

        button, input, optgroup, select, textarea {
            font-family: inherit;
            font-size: 100%;
            font-weight: inherit;
            line-height: inherit;
            color: inherit;
            margin: 0;
            padding: 0
        }

        button, select {
            text-transform: none
        }

        [type=button], [type=reset], [type=submit], button {
            -webkit-appearance: button;
            background-color: transparent;
            background-image: none
        }

        :-moz-focusring {
            outline: auto
        }

        :-moz-ui-invalid {
            box-shadow: none
        }

        progress {
            vertical-align: baseline
        }

        ::-webkit-inner-spin-button, ::-webkit-outer-spin-button {
            height: auto
        }

        [type=search] {
            -webkit-appearance: textfield;
            outline-offset: -2px
        }

        ::-webkit-search-decoration {
            -webkit-appearance: none
        }

        ::-webkit-file-upload-button {
            -webkit-appearance: button;
            font: inherit
        }

        summary {
            display: list-item
        }

        blockquote, dd, dl, figure, h1, h2, h3, h4, h5, h6, hr, p, pre {
            margin: 0
        }

        fieldset {
            margin: 0;
            padding: 0
        }

        legend {
            padding: 0
        }

        menu, ol, ul {
            list-style: none;
            margin: 0;
            padding: 0
        }

        textarea {
            resize: vertical
        }

        input::placeholder, textarea::placeholder {
            opacity: 1;
            color: #9ca3af
        }

        [role=button], button {
            cursor: pointer
        }

        :disabled {
            cursor: default
        }

        audio, canvas, embed, iframe, img, object, svg, video {
            display: block;
            vertical-align: middle
        }

        img, video {
            max-width: 100%;
            height: auto
        }

        [hidden] {
            display: none
        }

        *, ::before, ::after {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia:
        }

        ::-webkit-backdrop {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia:
        }

        ::backdrop {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia:
        }

        .relative {
            position: relative
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto
        }

        .mx-6 {
            margin-left: 1.5rem;
            margin-right: 1.5rem
        }

        .ml-4 {
            margin-left: 1rem
        }

        .mt-16 {
            margin-top: 4rem
        }

        .mt-6 {
            margin-top: 1.5rem
        }

        .mt-4 {
            margin-top: 1rem
        }

        .-mt-px {
            margin-top: -1px
        }

        .mr-1 {
            margin-right: 0.25rem
        }

        .flex {
            display: flex
        }

        .inline-flex {
            display: inline-flex
        }

        .grid {
            display: grid
        }

        .h-16 {
            height: 4rem
        }

        .h-7 {
            height: 1.75rem
        }

        .h-6 {
            height: 1.5rem
        }

        .h-5 {
            height: 1.25rem
        }

        .min-h-screen {
            min-height: 100vh
        }

        .w-auto {
            width: auto
        }

        .w-16 {
            width: 4rem
        }

        .w-7 {
            width: 1.75rem
        }

        .w-6 {
            width: 1.5rem
        }

        .w-5 {
            width: 1.25rem
        }

        .max-w-7xl {
            max-width: 80rem
        }

        .shrink-0 {
            flex-shrink: 0
        }

        .scale-100 {
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
        }

        .grid-cols-1 {
            grid-template-columns:repeat(1, minmax(0, 1fr))
        }

        .items-center {
            align-items: center
        }

        .justify-center {
            justify-content: center
        }

        .gap-6 {
            gap: 1.5rem
        }

        .gap-4 {
            gap: 1rem
        }

        .self-center {
            align-self: center
        }

        .rounded-lg {
            border-radius: 0.5rem
        }

        .rounded-full {
            border-radius: 9999px
        }

        .bg-gray-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(243 244 246 / var(--tw-bg-opacity))
        }

        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity))
        }

        .bg-red-50 {
            --tw-bg-opacity: 1;
            background-color: rgb(254 242 242 / var(--tw-bg-opacity))
        }

        .bg-dots-darker {
            background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E")
        }

        .from-gray-700\/50 {
            --tw-gradient-from: rgb(55 65 81 / 0.5);
            --tw-gradient-to: rgb(55 65 81 / 0);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to)
        }

        .via-transparent {
            --tw-gradient-to: rgb(0 0 0 / 0);
            --tw-gradient-stops: var(--tw-gradient-from), transparent, var(--tw-gradient-to)
        }

        .bg-center {
            background-position: center
        }

        .stroke-red-500 {
            stroke: #ef4444
        }

        .stroke-gray-400 {
            stroke: #9ca3af
        }

        .p-6 {
            padding: 1.5rem
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem
        }

        .text-center {
            text-align: center
        }

        .text-right {
            text-align: right
        }

        .text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem
        }

        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem
        }

        .font-semibold {
            font-weight: 600
        }

        .leading-relaxed {
            line-height: 1.625
        }

        .text-gray-600 {
            --tw-text-opacity: 1;
            color: rgb(75 85 99 / var(--tw-text-opacity))
        }

        .text-gray-900 {
            --tw-text-opacity: 1;
            color: rgb(17 24 39 / var(--tw-text-opacity))
        }

        .text-gray-500 {
            --tw-text-opacity: 1;
            color: rgb(107 114 128 / var(--tw-text-opacity))
        }

        .underline {
            -webkit-text-decoration-line: underline;
            text-decoration-line: underline
        }

        .antialiased {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }

        .shadow-2xl {
            --tw-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);
            --tw-shadow-colored: 0 25px 50px -12px var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
        }

        .shadow-gray-500\/20 {
            --tw-shadow-color: rgb(107 114 128 / 0.2);
            --tw-shadow: var(--tw-shadow-colored)
        }

        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms
        }

        .selection\:bg-red-500 *::selection {
            --tw-bg-opacity: 1;
            background-color: rgb(239 68 68 / var(--tw-bg-opacity))
        }

        .selection\:text-white *::selection {
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity))
        }

        .selection\:bg-red-500::selection {
            --tw-bg-opacity: 1;
            background-color: rgb(239 68 68 / var(--tw-bg-opacity))
        }

        .selection\:text-white::selection {
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity))
        }

        .hover\:text-gray-900:hover {
            --tw-text-opacity: 1;
            color: rgb(17 24 39 / var(--tw-text-opacity))
        }

        .hover\:text-gray-700:hover {
            --tw-text-opacity: 1;
            color: rgb(55 65 81 / var(--tw-text-opacity))
        }

        .focus\:rounded-sm:focus {
            border-radius: 0.125rem
        }

        .focus\:outline:focus {
            outline-style: solid
        }

        .focus\:outline-2:focus {
            outline-width: 2px
        }

        .focus\:outline-red-500:focus {
            outline-color: #ef4444
        }

        .group:hover .group-hover\:stroke-gray-600 {
            stroke: #4b5563
        }

        @media (prefers-reduced-motion: no-preference) {
            .motion-safe\:hover\:scale-\[1\.01\]:hover {
                --tw-scale-x: 1.01;
                --tw-scale-y: 1.01;
                transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
            }
        }

        @media (prefers-color-scheme: dark) {
            .dark\:bg-gray-900 {
                --tw-bg-opacity: 1;
                background-color: rgb(17 24 39 / var(--tw-bg-opacity))
            }

            .dark\:bg-gray-800\/50 {
                background-color: rgb(31 41 55 / 0.5)
            }

            .dark\:bg-red-800\/20 {
                background-color: rgb(153 27 27 / 0.2)
            }

            .dark\:bg-dots-lighter {
                background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E")
            }

            .dark\:bg-gradient-to-bl {
                background-image: linear-gradient(to bottom left, var(--tw-gradient-stops))
            }

            .dark\:stroke-gray-600 {
                stroke: #4b5563
            }

            .dark\:text-gray-400 {
                --tw-text-opacity: 1;
                color: rgb(156 163 175 / var(--tw-text-opacity))
            }

            .dark\:text-white {
                --tw-text-opacity: 1;
                color: rgb(255 255 255 / var(--tw-text-opacity))
            }

            .dark\:shadow-none {
                --tw-shadow: 0 0 #0000;
                --tw-shadow-colored: 0 0 #0000;
                box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
            }

            .dark\:ring-1 {
                --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
                --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);
                box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)
            }

            .dark\:ring-inset {
                --tw-ring-inset: inset
            }

            .dark\:ring-white\/5 {
                --tw-ring-color: rgb(255 255 255 / 0.05)
            }

            .dark\:hover\:text-white:hover {
                --tw-text-opacity: 1;
                color: rgb(255 255 255 / var(--tw-text-opacity))
            }

            .group:hover .dark\:group-hover\:stroke-gray-400 {
                stroke: #9ca3af
            }
        }

        @media (min-width: 640px) {
            .sm\:fixed {
                position: fixed
            }

            .sm\:top-0 {
                top: 0px
            }

            .sm\:right-0 {
                right: 0px
            }

            .sm\:ml-0 {
                margin-left: 0px
            }

            .sm\:flex {
                display: flex
            }

            .sm\:items-center {
                align-items: center
            }

            .sm\:justify-center {
                justify-content: center
            }

            .sm\:justify-between {
                justify-content: space-between
            }

            .sm\:text-left {
                text-align: left
            }

            .sm\:text-right {
                text-align: right
            }
        }

        @media (min-width: 768px) {
            .md\:grid-cols-2 {
                grid-template-columns:repeat(2, minmax(0, 1fr))
            }
        }

        @media (min-width: 1024px) {
            .lg\:gap-8 {
                gap: 2rem
            }

            .lg\:p-8 {
                padding: 2rem
            }
        }

        .header {
            /*background: #8BC523;*/
            background: #fff;
            height: 90px;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            border-bottom: 1px solid #e5e7eb;
        }

        .header .header-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 24px;
            max-width: 1280px;
            width: 100%;
        }

        .header .header-left {
            display: flex;
            align-items: center;
        }

        .header .header-left .brand-logo {
            height: 60px;
        }

        .header .header-left .brand-logo img {
            width: 100%;
            height: 100%;
        }

        .header .header-left .brand-logo {
            margin-right: 42px;
        }

        @media (max-width: 768px) {
            .header .header-left .brand-logo {
                margin-right: 24px;
            }

            .header .header-left .brand-logo {
                height: 50px;
            }
        }

        .header .header-left .header-nav {
            display: flex;
            align-items: center;
        }

        .header .header-left .header-nav .nav-list {
            display: flex;
            align-items: center;
        }

        .header .header-left .header-nav .nav-list .nav-item {
            margin-right: 24px;
        }

        .header .header-left .header-nav .nav-list .nav-item:last-child {
            margin-right: 0;
        }

        .header .header-left .header-nav .nav-list .nav-item .nav-link {
            color: #000;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
        }

        .header .header-left .header-nav .nav-list .nav-item .nav-link.active {
            color: #8BC523;
            background-color: #F3F4F6;
            border-radius: 4px;
            padding: 8px 16px;
        }

        .header .header-right .btn-login {
            background: #8BC523;
            border-radius: 4px;
            color: #fff;
            font-size: 14px;
            font-weight: 500;
            padding: 12px 24px;
            text-decoration: none;
        }

        .container {
            max-width: 1280px;
            width: 100%;
            margin: 0 auto;
            padding: 0 24px;
        }

        .bg-container {
            background: linear-gradient(90deg, rgba(0, 212, 255, 1) 0%, rgba(0, 255, 157, 1) 100%);
            height: 200px;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            border-bottom: 1px solid #e5e7eb;
            border-radius: 0 0 8px 8px;
        }

        @media (max-width: 768px) {
            .bg-container {
                height: 150px;
            }
        }

        .bg-container .container-wrapper {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .bg-container .container-wrapper .title {
            color: #fff;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        @media (max-width: 768px) {
            .bg-container .container-wrapper .title {
                font-size: 20px;
                margin-bottom: 6px;
            }
        }

        .bg-container .container-wrapper .description {
            color: #fff;
            font-size: 14px;
            font-weight: 400;
        }

        .main-wrapper {
            padding: 24px 0;
        }

        .main-wrapper .section {
            margin-bottom: 24px;
        }

        .main-wrapper .section .title {
            color: #000;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .main-wrapper .section p {
            color: #000;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.5;
            margin-bottom: 8px;
        }

        .main-wrapper .section ul {
            margin-left: 24px;
            list-style: disc;
            margin-bottom: 24px;
        }

        .main-wrapper .section ul li {
            color: #000;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.5;
            margin-bottom: 8px;
        }

        .main-wrapper .section ul li:last-child {
            margin-bottom: 0;
        }

        .footer {
            background: #ddd;
            height: 34px;
        }

        .footer .footer-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .footer .footer-wrapper .copyright-text {
            color: #000;
            font-size: 12px;
            font-weight: 400;
        }

        @media (max-width: 768px) {
            .footer .footer-wrapper .copyright-text {
                font-size: 10px;
            }
        }
    </style>
</head>
<body class="antialiased">
<main>
    <header class="header">
        <main class="header-wrapper">
            <div class="header-left">
                <div class="brand-logo">
                    <img src="{{ asset('images/brand-logo.png') }}" alt="Logo" class="logo">
                </div>

                <nav class="header-nav">
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a href="{{ route('privacy-policy') }}" class="nav-link active">Privacy Policy</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="header-right">
                <a href="/admin/login" class="btn-login">Login</a>
            </div>
        </main>
    </header>

    <main class="container">
        <header class="bg-container">
            <div class="container-wrapper">
                <h3 class="title">Privacy Policy</h3>
                <p class="description">Last updated: September 14, 2023</p>
            </div>
        </header>

        <main class="main-wrapper">
            <div class="section">
                <p class="title"><strong>Privacy Policy</strong></p>
                <p>PT Bara Lingua Mahayana built the Mafia Education Kenanga app as a Free app. This SERVICE
                    is
                    provided by PT Bara Lingua Mahayana at no cost and is
                    intended for use as is.</p>
                <p>This page is used to inform visitors regarding our policies with the collection, use, and
                    disclosure of Personal
                    Information if anyone decided to use our Service.</p>
                <p>If you choose to use our Service, then you agree to the collection and use of information
                    in
                    relation to this policy.
                    The Personal Information that we collect is used for providing and improving the Service.
                    We
                    will not use or share
                    your information with anyone except as described in this Privacy Policy.</p>
                <p>The terms used in this Privacy Policy have the same meanings as in our Terms and
                    Conditions,
                    which are accessible at
                    Mafia Education Kenanga unless otherwise defined in this Privacy Policy.</p>
            </div>
            <div class="section">

                <p class="title"><strong>Information Collection and Use</strong></p>
                <p>For a better experience, while using our Service, we may require you to provide us with
                    certain
                    personally
                    identifiable information, including but not limited to email, name. The information that
                    we
                    request will be retained
                    by us and used as described in this privacy policy.</p>
                <p>The app does use third-party services that may collect information used to identify
                    you.</p>
                <p>Link to the privacy policy of third-party service providers used by the app</p>
                <ul>
                    <li><a href="https://www.google.com/policies/privacy/">Google Play Services</a></li>
                </ul>
            </div>
            <div class="section">
                <p class="title"><strong>Log Data</strong></p>
                <p>We want to inform you that whenever you use our Service, in a case of an error in the app
                    we
                    collect data and
                    information (through third-party products) on your phone called Log Data. This Log Data
                    may
                    include information such
                    as your device Internet Protocol (&ldquo;IP&rdquo;) address, device name, operating system
                    version, the
                    configuration of the app when utilizing our Service, the time and date of your use of the
                    Service, and other
                    statistics.</p>
            </div>
            <div class="section">


                <p class="title"><strong>Cookies</strong></p>
                <p>Cookies are files with a small amount of data that are commonly used as anonymous unique
                    identifiers. These are sent
                    to your browser from the websites that you visit and are stored on your device's internal
                    memory.</p>
                <p>This Service does not use these &ldquo;cookies&rdquo; explicitly. However, the app may use
                    third-party code and
                    libraries that use &ldquo;cookies&rdquo; to collect information and improve their
                    services.
                    You have the option to
                    either accept or refuse these cookies and know when a cookie is being sent to your device.
                    If
                    you choose to refuse
                    our cookies, you may not be able to use some portions of this Service.</p>
            </div>
            <div class="section">

                <p class="title"><strong>Service Providers</strong></p>
                <p>We may employ third-party companies and individuals due to the following reasons:</p>
                <ul>
                    <li>To facilitate our Service;</li>
                    <li>To provide the Service on our behalf;</li>
                    <li>To perform Service-related services; or</li>
                    <li>To assist us in analyzing how our Service is used.</li>
                </ul>
                <p>We want to inform users of this Service that these third parties have access to their
                    Personal
                    Information. The
                    reason is to perform the tasks assigned to them on our behalf. However, they are obligated
                    not
                    to disclose or use
                    the information for any other purpose.</p>
            </div>
            <div class="section">

                <p class="title"><strong>Security</strong></p>
                <p>We value your trust in providing us your Personal Information, thus we are striving to use
                    commercially acceptable
                    means of protecting it. But remember that no method of transmission over the internet, or
                    method of electronic
                    storage is 100% secure and reliable, and we cannot guarantee its absolute security.</p>
            </div>
            <div class="section">

                <p class="title"><strong>Links to Other Sites</strong></p>
                <p>This Service may contain links to other sites. If you click on a third-party link, you will
                    be
                    directed to that site.
                    Note that these external sites are not operated by us. Therefore, we strongly advise you
                    to
                    review the Privacy
                    Policy of these websites. We have no control over and assume no responsibility for the
                    content, privacy policies, or
                    practices of any third-party sites or services.</p>
            </div>
            <div class="section">

                <p class="title"><strong>Children&rsquo;s Privacy</strong></p>
                <p>These Services do not address anyone under the age of 13. We do not knowingly collect
                    personally identifiable
                    information from children under 6 years of age. In the case we discover that a child under
                    6
                    has provided us with
                    personal information, we immediately delete this from our servers. If you are a parent or
                    guardian and you are aware
                    that your child has provided us with personal information, please contact us so that we
                    will
                    be able to do the
                    necessary actions.</p>
            </div>
            <div class="section">

                <p class="title"><strong>Changes to This Privacy Policy</strong></p>
                <p>We may update our Privacy Policy from time to time. Thus, you are advised to review this
                    page
                    periodically for any
                    changes. We will notify you of any changes by posting the new Privacy Policy on this
                    page.</p>
                <p>This policy is effective as of 2023-10-04</p>
            </div>
            <div class="section">

                <p class="title"><strong>Contact Us</strong></p>
                <p>If you have any questions or suggestions about our Privacy Policy, do not hesitate to
                    contact
                    us at
                    mafiaeducationofficial@gmail.com.</p>
                <p>This privacy policy page was created at&nbsp;<a
                        href="https://privacypolicytemplate.net/">privacypolicytemplate.net&nbsp;</a>and
                    modified/generated by&nbsp;<a
                        href="https://app-privacy-policy-generator.nisrulz.com/">App Privacy Policy
                        Generator</a>
                </p>
            </div>
            <div class="section">

                <p class="title"><strong>Terms &amp; Conditions</strong></p>
                <p>By downloading or using the app, these terms will automatically apply to you &ndash; you
                    should
                    make sure therefore
                    that you read them carefully before using the app. You&rsquo;re not allowed to copy or
                    modify
                    the app, any part of
                    the app, or our trademarks in any way. You&rsquo;re not allowed to attempt to extract the
                    source code of the app,
                    and you also shouldn&rsquo;t try to translate the app into other languages or make
                    derivative
                    versions. The app
                    itself, and all the trademarks, copyright, database rights, and other intellectual
                    property
                    rights related to it,
                    still belong to PT Bara Lingua Mahayana.</p>
                <p>PT Bara Lingua Mahayana is committed to ensuring that the app is as useful and efficient as
                    possible. For that reason, we
                    reserve the right to make changes to the app or to charge for its services, at any time
                    and
                    for any reason. We will
                    never charge you for the app or its services without making it very clear to you exactly
                    what
                    you&rsquo;re paying
                    for.</p>
                <p>The Mafia Education Kenanga app stores and processes personal data that you have provided
                    to
                    us, to provide our Service. It&rsquo;s
                    your responsibility to keep your phone and access to the app secure. We therefore
                    recommend
                    that you do not
                    jailbreak or root your phone, which is the process of removing software restrictions and
                    limitations imposed by the
                    official operating system of your device. It could make your phone vulnerable to
                    malware/viruses/malicious programs,
                    compromise your phone&rsquo;s security features and it could mean that the Mafia Education
                    Kenanga app won&rsquo;t work properly or at
                    all.</p>
                <p>The app does use third-party services that declare their Terms and Conditions.</p>
                <p>Link to Terms and Conditions of third-party service providers used by the app</p>
                <ul>
                    <li><a href="https://policies.google.com/terms">Google Play Services</a></li>
                </ul>
                <p>You should be aware that there are certain things that PT Bara Lingua Mahayana will not
                    take
                    responsibility for. Certain
                    functions of the app will require the app to have an active internet connection. The
                    connection can be Wi-Fi or
                    provided by your mobile network provider, but PT Bara Lingua Mahayana cannot take
                    responsibility for the app not working at
                    full functionality if you don&rsquo;t have access to Wi-Fi, and you don&rsquo;t have any
                    of
                    your data allowance
                    left.</p>
                <p>If you&rsquo;re using the app outside of an area with Wi-Fi, you should remember that the
                    terms
                    of the agreement with
                    your mobile network provider will still apply. As a result, you may be charged by your
                    mobile
                    provider for the cost
                    of data for the duration of the connection while accessing the app, or other third-party
                    charges. In using the app,
                    you&rsquo;re accepting responsibility for any such charges, including roaming data charges
                    if
                    you use the app
                    outside of your home territory (i.e. region or country) without turning off data roaming.
                    If
                    you are not the bill
                    payer for the device on which you&rsquo;re using the app, please be aware that we assume
                    that
                    you have received
                    permission from the bill payer for using the app.</p>
                <p>Along the same lines, PT Bara Lingua Mahayana cannot always take responsibility for the way
                    you
                    use the app i.e. You need to
                    make sure that your device stays charged &ndash; if it runs out of battery and you can&rsquo;t
                    turn it on to avail
                    the Service, PT Bara Lingua Mahayana cannot accept responsibility.</p>
                <p>With respect to PT Bara Lingua Mahayana&rsquo;s responsibility for your use of the app,
                    when
                    you&rsquo;re using the app,
                    it&rsquo;s important to bear in mind that although we endeavor to ensure that it is
                    updated
                    and correct at all
                    times, we do rely on third parties to provide information to us so that we can make it
                    available to you. PT Bara Lingua Mahayana accepts no liability for any loss, direct or
                    indirect, you experience as a result of relying wholly on this
                    functionality of the app.</p>
                <p>At some point, we may wish to update the app. The app is currently available on Android
                    &ndash;
                    the requirements for
                    the system(and for any additional systems we decide to extend the availability of the app
                    to)
                    may change, and
                    you&rsquo;ll need to download the updates if you want to keep using the app. PT Bara
                    Lingua
                    Mahayana does not promise that
                    it will always update the app so that it is relevant to you and/or works with the Android
                    version that you have
                    installed on your device. However, you promise to always accept updates to the application
                    when offered to you, We
                    may also wish to stop providing the app, and may terminate use of it at any time without
                    giving notice of
                    termination to you. Unless we tell you otherwise, upon any termination, (a) the rights and
                    licenses granted to you
                    in these terms will end; (b) you must stop using the app, and (if needed) delete it from
                    your
                    device.</p>
            </div>
            <div class="section">

                <p class="title"><strong>Changes to This Terms and Conditions</strong></p>
                <p>We may update our Terms and Conditions from time to time. Thus, you are advised to review
                    this
                    page periodically for
                    any changes. We will notify you of any changes by posting the new Terms and Conditions on
                    this
                    page.</p>
                <p>These terms and conditions are effective as of 2022-04-01</p>
            </div>
            <div class="section">

                <p class="title"><strong>Contact Us</strong></p>
                <p>If you have any questions or suggestions about our Terms and Conditions, do not hesitate to
                    contact us at
                    mafiaeducationofficial@gmail.com.</p>
                <p>This Terms and Conditions page was generated by&nbsp;<a
                        href="https://app-privacy-policy-generator.nisrulz.com/">App
                        Privacy Policy Generator</a></p>
            </div>
        </main>
    </main>

    <footer class="footer">
        <div class="footer-wrapper">
            <div class="copyright-text">
                <p>&copy; 2023 Mafia Education Kenanga. All rights reserved.</p>
            </div>
        </div>
    </footer>
</main>
</body>
</html>
