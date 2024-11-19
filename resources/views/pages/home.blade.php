<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Fest Connection</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href={{ asset('css/app.css') }} rel="stylesheet">

        <script src="https://cdn.tailwindcss.com"></script>
        <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
        <script src={{ asset('js/app.js') }}></script>

        <!-- Styles -->
        <style>
            /* ! tailwindcss v3.2.4 | MIT License | https://tailwindcss.com */*,::after,::before{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}::after,::before{--tw-content:''}html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;tab-size:4;font-family:Figtree, sans-serif;font-feature-settings:normal}body{margin:0;line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,pre,samp{font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}button,input,optgroup,select,textarea{font-family:inherit;font-size:100%;font-weight:inherit;line-height:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}[type=button],[type=reset],[type=submit],button{-webkit-appearance:button;background-color:transparent;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}progress{vertical-align:baseline}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary{display:list-item}blockquote,dd,dl,figure,h1,h2,h3,h4,h5,h6,hr,p,pre{margin:0}fieldset{margin:0;padding:0}legend{padding:0}menu,ol,ul{list-style:none;margin:0;padding:0}textarea{resize:vertical}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}[role=button],button{cursor:pointer}:disabled{cursor:default}audio,canvas,embed,iframe,img,object,svg,video{display:block;vertical-align:middle}img,video{max-width:100%;height:auto}[hidden]{display:none}*, ::before, ::after{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }::-webkit-backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }::backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }.relative{position:relative}.mx-auto{margin-left:auto;margin-right:auto}.mx-6{margin-left:1.5rem;margin-right:1.5rem}.ml-4{margin-left:1rem}.mt-16{margin-top:4rem}.mt-6{margin-top:1.5rem}.mt-4{margin-top:1rem}.-mt-px{margin-top:-1px}.mr-1{margin-right:0.25rem}.flex{display:flex}.inline-flex{display:inline-flex}.grid{display:grid}.h-16{height:4rem}.h-7{height:1.75rem}.h-6{height:1.5rem}.h-5{height:1.25rem}.min-h-screen{min-height:100vh}.w-auto{width:auto}.w-16{width:4rem}.w-7{width:1.75rem}.w-6{width:1.5rem}.w-5{width:1.25rem}.max-w-7xl{max-width:80rem}.shrink-0{flex-shrink:0}.scale-100{--tw-scale-x:1;--tw-scale-y:1;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}.grid-cols-1{grid-template-columns:repeat(1, minmax(0, 1fr))}.items-center{align-items:center}.justify-center{justify-content:center}.gap-6{gap:1.5rem}.gap-4{gap:1rem}.self-center{align-self:center}.rounded-lg{border-radius:0.5rem}.rounded-full{border-radius:9999px}.bg-gray-100{--tw-bg-opacity:1;background-color:rgb(243 244 246 / var(--tw-bg-opacity))}.bg-white{--tw-bg-opacity:1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-red-50{--tw-bg-opacity:1;background-color:rgb(254 242 242 / var(--tw-bg-opacity))}.bg-dots-darker{background-image:url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E")}.from-gray-700\/50{--tw-gradient-from:rgb(55 65 81 / 0.5);--tw-gradient-to:rgb(55 65 81 / 0);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.via-transparent{--tw-gradient-to:rgb(0 0 0 / 0);--tw-gradient-stops:var(--tw-gradient-from), transparent, var(--tw-gradient-to)}.bg-center{background-position:center}.stroke-red-500{stroke:#ef4444}.stroke-gray-400{stroke:#9ca3af}.p-6{padding:1.5rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.text-center{text-align:center}.text-right{text-align:right}.text-xl{font-size:1.25rem;line-height:1.75rem}.text-sm{font-size:0.875rem;line-height:1.25rem}.font-semibold{font-weight:600}.leading-relaxed{line-height:1.625}.text-gray-600{--tw-text-opacity:1;color:rgb(75 85 99 / var(--tw-text-opacity))}.text-gray-900{--tw-text-opacity:1;color:rgb(17 24 39 / var(--tw-text-opacity))}.text-gray-500{--tw-text-opacity:1;color:rgb(107 114 128 / var(--tw-text-opacity))}.underline{-webkit-text-decoration-line:underline;text-decoration-line:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.shadow-2xl{--tw-shadow:0 25px 50px -12px rgb(0 0 0 / 0.25);--tw-shadow-colored:0 25px 50px -12px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.shadow-gray-500\/20{--tw-shadow-color:rgb(107 114 128 / 0.2);--tw-shadow:var(--tw-shadow-colored)}.transition-all{transition-property:all;transition-timing-function:cubic-bezier(0.4, 0, 0.2, 1);transition-duration:150ms}.selection\:bg-red-500 *::selection{--tw-bg-opacity:1;background-color:rgb(239 68 68 / var(--tw-bg-opacity))}.selection\:text-white *::selection{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.selection\:bg-red-500::selection{--tw-bg-opacity:1;background-color:rgb(239 68 68 / var(--tw-bg-opacity))}.selection\:text-white::selection{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.hover\:text-gray-900:hover{--tw-text-opacity:1;color:rgb(17 24 39 / var(--tw-text-opacity))}.hover\:text-gray-700:hover{--tw-text-opacity:1;color:rgb(55 65 81 / var(--tw-text-opacity))}.focus\:rounded-sm:focus{border-radius:0.125rem}.focus\:outline:focus{outline-style:solid}.focus\:outline-2:focus{outline-width:2px}.focus\:outline-red-500:focus{outline-color:#ef4444}.group:hover .group-hover\:stroke-gray-600{stroke:#4b5563}.z-10{z-index: 10}@media (prefers-reduced-motion: no-preference){.motion-safe\:hover\:scale-\[1\.01\]:hover{--tw-scale-x:1.01;--tw-scale-y:1.01;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}}@media (prefers-color-scheme: dark){.dark\:bg-gray-900{--tw-bg-opacity:1;background-color:rgb(17 24 39 / var(--tw-bg-opacity))}.dark\:bg-gray-800\/50{background-color:rgb(31 41 55 / 0.5)}.dark\:bg-red-800\/20{background-color:rgb(153 27 27 / 0.2)}.dark\:bg-dots-lighter{background-image:url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E")}.dark\:bg-gradient-to-bl{background-image:linear-gradient(to bottom left, var(--tw-gradient-stops))}.dark\:stroke-gray-600{stroke:#4b5563}.dark\:text-gray-400{--tw-text-opacity:1;color:rgb(156 163 175 / var(--tw-text-opacity))}.dark\:text-white{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.dark\:shadow-none{--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.dark\:ring-1{--tw-ring-offset-shadow:var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow:var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow:var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)}.dark\:ring-inset{--tw-ring-inset:inset}.dark\:ring-white\/5{--tw-ring-color:rgb(255 255 255 / 0.05)}.dark\:hover\:text-white:hover{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.group:hover .dark\:group-hover\:stroke-gray-400{stroke:#9ca3af}}@media (min-width: 640px){.sm\:fixed{position:fixed}.sm\:top-0{top:0px}.sm\:right-0{right:0px}.sm\:ml-0{margin-left:0px}.sm\:flex{display:flex}.sm\:items-center{align-items:center}.sm\:justify-center{justify-content:center}.sm\:justify-between{justify-content:space-between}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width: 768px){.md\:grid-cols-2{grid-template-columns:repeat(2, minmax(0, 1fr))}}@media (min-width: 1024px){.lg\:gap-8{gap:2rem}.lg\:p-8{padding:2rem}}
        </style>
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-800/60 dark:bg-dots-lighter dark:bg-gray-900/70 selection:bg-red-500 selection:text-white">
            <div id="video-bg">
                <video class="home_video" autoplay muted loop>
                    <source src={{ asset('img/video/home_bg.mp4') }} type="video/mp4">
                </video>
            </div>
            <div class="bg_hero sm:justify-center sm:items-center min-h-screen ">
            <div class="max-w-7xl sm:max-w-1xl mx-auto lg:my-40 sm:p-5 lg:p-8 bg_top">

                <div class="flex flex-col lg:flex-row justify-center">
                    <div class="justify-center mx-auto">
                    <svg width="300px" height="300px" viewBox="0 0 1024 1024" class="icon"  version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M879.028 203.277H559.911l-19.06-65.018-13.486-7.694-79.352 20.153-8.087 13.591 32.411 127.623-0.94-0.717-16.65 3.634-20.152 37.788v10.529l27.896 52.297-15.354 42.652-12.823-11.537-17.291 2.934-21.411 39.048-0.044 10.683 14.316 26.578-18.622 25.781-7.694-13.082-17.392-2.396-28.971 27.845-3.433 8.065v25.355l-36.831 15.67v-20.873l-17.261-9.39-37.34 24.161-36.969-19.414 8.155-35.695-9.48-13.583-33.853-4.344c-4.73-13.941-15.146-58.723 3.088-149.897l-19.989-8.8c-3.513 4.795-85.815 118.703-66.081 227.416 8.738 48.131 36.182 87.602 81.577 117.308 58.261 38.126 113.201 59.903 161.503 70.838L301.8 843.32l6.077 14.4 43.457 18.262 4.332 0.874h61.09l11.185-11.185v-35.899l-8.002-10.722-25.403-7.54 22.244-31.687c38.495-1.064 67.92-9.498 84.787-19.604a66.58 66.58 0 0 0 2.791 3.043l-50.069 69.417 4.948 16.94 66.758 26.451 4.121 0.787h74.317l11.185-11.185v-39.049l-11.185-11.185H561.56l-0.83-0.622 54.114-45.205a56.864 56.864 0 0 0 20.466-43.756c0-15.734-6.448-30.6-17.783-41.34 15.295-11.2 39.943-34.087 57.577-74.211a89.004 89.004 0 0 0 29.645-13.515l24.754-17.388c11.956-8.4 26.007-12.841 40.624-12.841h46.235l11.185-11.185v-23.618l-8.986-10.966-53.946-10.813a92.828 92.828 0 0 0-52.756 4.809l-16.193 6.458c2.909-29.346 0.317-50.997-4.015-78.002h187.377l11.185-11.185V214.462l-11.185-11.185z" fill="#FCE3C3" /><path d="M559.911 203.277l-19.06-65.018-13.486-7.694-79.352 20.153-8.087 13.591 32.411 127.623-0.94-0.717-16.65 3.634-20.152 37.788v10.529l27.896 52.297-15.354 42.652-12.823-11.537-17.291 2.934-21.411 39.048-0.044 10.683 14.316 26.578-18.622 25.781-7.694-13.082-17.392-2.396-28.971 27.845-3.433 8.065v25.355l-36.831 15.67v-20.873l-17.261-9.39-37.34 24.161-36.969-19.414 8.155-35.695-9.48-13.583-33.853-4.344c-4.73-13.941-15.146-58.723 3.088-149.897l-19.989-8.8c-1.726 2.356-22.462 31.05-40.777 72.514-15.495 70.715 0.845 167.923 42.855 211.574 42.014 43.655 131.834 89.688 262.033 40.39C573.468 620.61 545.321 522.858 576.112 477.07c34.974-52.007 91.302-43.105 91.302-43.105l57.126 9.277h154.488l11.185-11.185V214.462l-11.185-11.185H559.911z" fill="#ED8F27" /><path d="M604.435 876.857h-74.317l-4.121-0.787-66.759-26.451-4.948-16.94 50.069-69.417c-13.114-13.377-16.08-28.679-35.58-28.679v-22.369c37.435 0 54.215 37.905 58.489 42.882l0.586 13.832-47.017 65.185 51.416 20.375h60.998v-16.679h-35.418l-6.71-2.235-15.117-11.334-0.459-17.534 64.96-54.264a34.55 34.55 0 0 0 12.434-26.585 34.55 34.55 0 0 0-12.434-26.582l-2.039-2.238-40.771-44.378 18.415-12.692 39.952 43.187c12.252 10.825 19.246 26.298 19.246 42.704a56.864 56.864 0 0 1-20.466 43.756l-54.114 45.205 0.83 0.622h42.875l11.185 11.185v39.049l-11.185 11.182zM416.756 876.857h-61.09l-4.332-0.874-43.457-18.263-6.077-14.399 33.365-84.942 20.818 8.178-29.37 74.772 31.307 13.158h47.652v-16.366l-32.306-9.59-5.971-17.148 34.639-49.341 18.307 12.852-25.705 36.616 25.403 7.54 8.002 10.723v35.899z" fill="#300604" /><path d="M408.575 779.944c-62.543 0.004-146.952-19.246-239.787-79.997-45.394-29.706-72.838-69.177-81.577-117.308-19.734-108.712 62.568-222.62 66.081-227.415l19.989 8.8c-18.233 91.174-7.817 135.957-3.088 149.897l33.853 4.344 9.48 13.583-8.155 35.695 36.969 19.414 37.34-24.161 17.261 9.39v20.873l36.831-15.67v-25.355l3.433-8.065 28.971-27.845 17.392 2.396 7.694 13.082 18.622-25.781-14.316-26.578 0.044-10.683 21.411-39.048 17.291-2.934 12.823 11.537 15.354-42.652-27.896-52.297v-10.529l20.152-37.788 16.65-3.634 0.94 0.717-32.411-127.623 8.087-13.591 79.352-20.153 13.486 7.694 19.06 65.018h319.117l11.185 11.185v217.595l-11.185 11.185H691.652c5.29 32.983 7.992 57.971 1.237 98.756l-21.812 3.457c7.071-42.696 2.523-75.755-3.663-111.49l11.021-13.093h189.409V225.646h-316.31l-10.734-8.039-18.382-62.707-58.057 14.742 37.551 147.873-17.618 11.651-15.994-12.19-11.156 20.924 27.423 51.416 0.652 9.051-22.671 62.98-18.004 4.525-14.694-13.224-11.702 21.336 14.756 27.397-0.782 11.854-32.75 45.347-18.707-0.881-9.197-15.634-15.324 14.727v27.988l-6.805 10.292-59.201 25.191-15.565-10.292v-17.229l-25.566 16.541-11.276 0.513-50.382-26.45-5.705-12.393 7.329-32.073-28.082-3.601-8.334-5.625c-0.874-1.558-17.793-33.034-9.925-112.742-20.964 41.462-44.01 103.502-33.398 161.807 7.613 41.823 31.771 76.309 71.801 102.504 165.429 108.261 296.228 74.114 314.723 55.618l15.816 15.816c-13.881 13.883-50.836 27.282-102.999 27.285z" fill="#300604" /><path d="M603.565 693.288l-9.692-20.163 4.846 10.082-4.889-10.06c0.385-0.189 38.56-19.449 61.756-74.047l20.585 8.745c-26.677 62.797-70.746 84.548-72.606 85.443zM745.07 314.958h129.935v22.369H745.07z" fill="#300604" /><path d="M653.554 612.965a88.946 88.946 0 0 1-30.339-5.33l-14.635-3.016L614.333 583l16.127 3.463a66.677 66.677 0 0 0 61.432-7.981l24.751-17.388c15.743-11.057 34.239-16.905 53.484-16.905h35.051v-3.27l-44.961-9.011a70.521 70.521 0 0 0-40.071 3.652l-56.776 22.642-6.124 0.619c-2.115-0.379-22.216 10.667-63.416-55.188l18.962-11.862c30.67 49.017 35.447 41.415 45.616 44.331l53.452-21.317c16.791-6.699 35.024-8.359 52.756-4.809l53.946 10.813 8.986 10.966v23.618l-11.185 11.185h-46.235c-14.618 0-28.668 4.442-40.624 12.842l-24.754 17.388a89.067 89.067 0 0 1-51.196 16.177z" fill="#300604" /><path d="M734.235 861.672l33-81.426 20.73 8.402-32.998 81.426zM801.765 867.314l-20.731-8.402 13.704-33.817 20.732 8.402z" fill="#300604" /><path d="M215.058 870.01l-32.999-81.427 20.732-8.402 32.999 81.426zM154.596 833.525l20.732-8.402 13.705 33.818-20.732 8.401z" fill="#300604" /><path d="M593.829 255.953l88.179 29.046s-12.991 51.601-66.423 32.75c-31.277-11.036-21.756-61.796-21.756-61.796z" fill="#300604" /><path d="M745.07 324.249l22.111 53.888 24.047-52.997z" fill="#FCE3C3" /><path d="M775.376 381.855l-16.521-0.303-22.11-53.888 8.5-12.414 46.158 0.891 8.021 12.717-24.048 52.997z m-16.777-48.343l8.998 21.929 9.785-21.566-18.783-0.363z" fill="#300604" /><path d="M262.403 363.322s8.039 8.12 26.008 9.23 22.886-6.701 22.886-6.701l28.651-48.029-34.328-49.225-35.169 15.317-22.901 45.142 14.853 34.266z" fill="#B12800" /><path d="M262.403 363.322c-8.077-20.119-2.497-31.056 5.466-40.865 8.542-11.245 11.191-22.363 11.191-22.363s5.87 8.21 2.642 20.764c11.504-11.552 14.666-30.977 13.652-38.397 23.376 18.611 31.803 56.9 15.943 83.389 77.905-38.354 25.176-105.865 15.826-113.31 2.968 7.541 2.702 19.787-4.501 25.228-8.584-43.694-35.923-53.721-35.923-53.721 2.063 22.2-14.563 45.208-30.339 62.382 0.054-8.826-0.072-14.719-4.415-23.817-1.973 16.065-14.973 28.015-19.39 43.929-5.755 21.719 1.097 37.839 29.848 56.781z" fill="#B12800" /><path d="M331.907 458.698s3.643 3.68 11.785 4.182c8.143 0.503 10.371-3.037 10.371-3.037l12.983-21.764-15.556-22.306-15.937 6.941-10.378 20.456 6.732 15.528z" fill="#B12800" /><path d="M331.907 458.698c-3.66-9.117-1.131-14.073 2.477-18.518 3.871-5.095 5.071-10.134 5.071-10.134s2.66 3.721 1.197 9.409c5.213-5.235 6.646-14.037 6.187-17.4 10.593 8.434 14.411 25.784 7.224 37.787 35.303-17.38 11.408-47.973 7.171-51.346 1.345 3.417 1.225 8.966-2.039 11.432-3.89-19.8-16.278-24.343-16.278-24.343 0.935 10.06-6.599 20.486-13.748 28.268 0.025-3.999-0.033-6.67-2.001-10.792-0.894 7.28-6.785 12.695-8.786 19.906-2.609 9.843 0.496 17.147 13.525 25.731z" fill="#B12800" /></svg>
                    </div>
                    <!--
                    <svg viewBox="0 0 62 65" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-16 w-auto bg-gray-100 dark:bg-gray-900">
                        <path d="M61.8548 14.6253C61.8778 14.7102 61.8895 14.7978 61.8897 14.8858V28.5615C61.8898 28.737 61.8434 28.9095 61.7554 29.0614C61.6675 29.2132 61.5409 29.3392 61.3887 29.4265L49.9104 36.0351V49.1337C49.9104 49.4902 49.7209 49.8192 49.4118 49.9987L25.4519 63.7916C25.3971 63.8227 25.3372 63.8427 25.2774 63.8639C25.255 63.8714 25.2338 63.8851 25.2101 63.8913C25.0426 63.9354 24.8666 63.9354 24.6991 63.8913C24.6716 63.8838 24.6467 63.8689 24.6205 63.8589C24.5657 63.8389 24.5084 63.8215 24.456 63.7916L0.501061 49.9987C0.348882 49.9113 0.222437 49.7853 0.134469 49.6334C0.0465019 49.4816 0.000120578 49.3092 0 49.1337L0 8.10652C0 8.01678 0.0124642 7.92953 0.0348998 7.84477C0.0423783 7.8161 0.0598282 7.78993 0.0697995 7.76126C0.0884958 7.70891 0.105946 7.65531 0.133367 7.6067C0.152063 7.5743 0.179485 7.54812 0.20192 7.51821C0.230588 7.47832 0.256763 7.43719 0.290416 7.40229C0.319084 7.37362 0.356476 7.35243 0.388883 7.32751C0.425029 7.29759 0.457436 7.26518 0.498568 7.2415L12.4779 0.345059C12.6296 0.257786 12.8015 0.211853 12.9765 0.211853C13.1515 0.211853 13.3234 0.257786 13.475 0.345059L25.4531 7.2415H25.4556C25.4955 7.26643 25.5292 7.29759 25.5653 7.32626C25.5977 7.35119 25.6339 7.37362 25.6625 7.40104C25.6974 7.43719 25.7224 7.47832 25.7523 7.51821C25.7735 7.54812 25.8021 7.5743 25.8196 7.6067C25.8483 7.65656 25.8645 7.70891 25.8844 7.76126C25.8944 7.78993 25.9118 7.8161 25.9193 7.84602C25.9423 7.93096 25.954 8.01853 25.9542 8.10652V33.7317L35.9355 27.9844V14.8846C35.9355 14.7973 35.948 14.7088 35.9704 14.6253C35.9792 14.5954 35.9954 14.5692 36.0053 14.5405C36.0253 14.4882 36.0427 14.4346 36.0702 14.386C36.0888 14.3536 36.1163 14.3274 36.1375 14.2975C36.1674 14.2576 36.1923 14.2165 36.2272 14.1816C36.2559 14.1529 36.292 14.1317 36.3244 14.1068C36.3618 14.0769 36.3942 14.0445 36.4341 14.0208L48.4147 7.12434C48.5663 7.03694 48.7383 6.99094 48.9133 6.99094C49.0883 6.99094 49.2602 7.03694 49.4118 7.12434L61.3899 14.0208C61.4323 14.0457 61.4647 14.0769 61.5021 14.1055C61.5333 14.1305 61.5694 14.1529 61.5981 14.1803C61.633 14.2165 61.6579 14.2576 61.6878 14.2975C61.7103 14.3274 61.7377 14.3536 61.7551 14.386C61.7838 14.4346 61.8 14.4882 61.8199 14.5405C61.8312 14.5692 61.8474 14.5954 61.8548 14.6253ZM59.893 27.9844V16.6121L55.7013 19.0252L49.9104 22.3593V33.7317L59.8942 27.9844H59.893ZM47.9149 48.5566V37.1768L42.2187 40.4299L25.953 49.7133V61.2003L47.9149 48.5566ZM1.99677 9.83281V48.5566L23.9562 61.199V49.7145L12.4841 43.2219L12.4804 43.2194L12.4754 43.2169C12.4368 43.1945 12.4044 43.1621 12.3682 43.1347C12.3371 43.1097 12.3009 43.0898 12.2735 43.0624L12.271 43.0586C12.2386 43.0275 12.2162 42.9888 12.1887 42.9539C12.1638 42.9203 12.1339 42.8916 12.114 42.8567L12.1127 42.853C12.0903 42.8156 12.0766 42.7707 12.0604 42.7283C12.0442 42.6909 12.023 42.656 12.013 42.6161C12.0005 42.5688 11.998 42.5177 11.9931 42.4691C11.9881 42.4317 11.9781 42.3943 11.9781 42.3569V15.5801L6.18848 12.2446L1.99677 9.83281ZM12.9777 2.36177L2.99764 8.10652L12.9752 13.8513L22.9541 8.10527L12.9752 2.36177H12.9777ZM18.1678 38.2138L23.9574 34.8809V9.83281L19.7657 12.2459L13.9749 15.5801V40.6281L18.1678 38.2138ZM48.9133 9.14105L38.9344 14.8858L48.9133 20.6305L58.8909 14.8846L48.9133 9.14105ZM47.9149 22.3593L42.124 19.0252L37.9323 16.6121V27.9844L43.7219 31.3174L47.9149 33.7317V22.3593ZM24.9533 47.987L39.59 39.631L46.9065 35.4555L36.9352 29.7145L25.4544 36.3242L14.9907 42.3482L24.9533 47.987Z" fill="#FF2D20"/>
                    </svg>
                    -->
                    <div>
                    <span class="flex shadow_lg justify-center p-10 text-5xl lg:text-8xl bg-gradient-to-br from-cyan-400 to-violet-700 bg-clip-text text-transparent">Fest<br/>Connection</span>
                    </div>
                </div>

                <div class="mt-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                        
                        <a href="/missed_connections" class="scale-100 mx-10 p-6 bg-slate-900/80 border-slate-900 border-solid rounded-md border-2 dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                

                                <h2 class="mt-6 text-3xl font-semibold text-gray-300 dark:text-white">Find a Missed Connection!</h2>

                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Find a lost connection or friend made at an festival and connect with them and groups.
                                </p>
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                            </svg>
                        </a>

                        <a href="#" class="scale-100 mx-10 p-6 bg-slate-900/80 border-slate-900 border-solid rounded-md border-2 dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                

                                <h2 class="mt-6 text-3xl font-semibold text-gray-300 dark:text-white">Find a Vendor</h2>

                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Find a food vendor, art vendor, or clothing vendor from an event recently attended or remembered. 
                                </p>
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                            </svg>
                        </a>

                    </div>
                </div>

                <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">
                    <div class="text-center text-sm sm:text-left">
                        &nbsp;
                    </div>

                    <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
                        FestConnection 2024 &copy; All rights reserved.
                    </div>
                </div>
            </div>
            </div>
        </div>
    </body>
</html>
