<?php /* vista del home */ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect"/>
<link as="style" href="https://fonts.googleapis.com/css2?display=swap&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900&amp;family=Public+Sans%3Awght%40400%3B500%3B700%3B900" onload="this.rel='stylesheet'" rel="stylesheet"/>
<title>Stitch Design</title>
<link href="data:image/x-icon;base64," rel="icon" type="image/x-icon"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<style type="text/tailwindcss">
  :root {
    --primary-color: #1173d4;
    --secondary-color: #f0f2f4;
    --text-primary: #111418;
    --text-secondary: #617589;
  }
  .btn-primary { @apply bg-[var(--primary-color)] text-white; }
  .btn-secondary { @apply bg-[var(--secondary-color)] text-[var(--text-primary)]; }
</style>
</head>
<body class="bg-gray-50 text-gray-900" style='font-family: "Public Sans", "Noto Sans", sans-serif;'>
<div class="relative flex size-full min-h-screen flex-col group/design-root overflow-x-hidden">
  <div class="layout-container flex h-full grow flex-col">
    <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-gray-200 px-10 py-3 bg-white">
      <div class="flex items-center gap-4 text-gray-900">
        <div class="size-6 text-[var(--primary-color)]">
          <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" d="M24 4H42V17.3333V30.6667H24V44H6V30.6667V17.3333H24V4Z" fill="currentColor" fill-rule="evenodd"></path>
          </svg>
        </div>
        <h2 class="text-xl font-bold leading-tight tracking-[-0.015em]">Community Hub</h2>
      </div>
      <div class="flex flex-1 justify-end gap-4">
        <div class="flex items-center gap-6">
          <a class="text-sm font-medium leading-normal text-gray-600 hover:text-gray-900" href="#">Home</a>
          <a class="text-sm font-medium leading-normal text-gray-600 hover:text-gray-900" href="#">Events</a>
          <a class="text-sm font-medium leading-normal text-gray-600 hover:text-gray-900" href="#">Groups</a>
          <a class="text-sm font-medium leading-normal text-gray-600 hover:text-gray-900" href="#">Marketplace</a>
          <a class="text-sm font-medium leading-normal text-gray-600 hover:text-gray-900" href="#">Services</a>
        </div>
        <div class="flex items-center gap-4">
          <button class="flex size-10 cursor-pointer items-center justify-center rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">
            <span class="material-symbols-outlined"> notifications </span>
          </button>
          <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuA1QRsUPYSYbswP98UjaiyEPnVk55Do2VHhd0tgMMhilI0G7q7M9g3BQ1Q1O48BUkFc2Ab07qePBVLlzKerFvzEMvDoxYlbiMx_GCbkNZCfda-GGevsw0-Tvbt5JcBTLiKzrDGEtg6XFgUFH7KFAyXaUMBPRd_48aIkAx-wLCYOJkd9L5NWQWAuDAqINmI7fUwvZAMnQ06xEf2T2LAlKIwcoQyHMwrZ2EdhdobGWiHQNPRzGmA6TeYXm3xqIp5TweU_jhHT5eQApds");'></div>
        </div>
      </div>
    </header>

    <main class="flex-1 px-4 py-8 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-4xl">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
          <h1 class="text-3xl font-bold leading-tight tracking-tight text-gray-900">Community News</h1>
          <button class="btn-primary flex min-w-[84px] items-center justify-center gap-2 rounded-md h-10 px-4 text-sm font-medium leading-normal shadow-sm hover:bg-opacity-90">
            <span class="material-symbols-outlined"> add </span>
            <span class="truncate">Create News</span>
          </button>
        </div>

        <div class="mb-6">
          <div class="relative">
            <span class="material-symbols-outlined pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"> search </span>
            <input class="form-input w-full rounded-md border-gray-300 bg-white py-2 pl-10 pr-4 text-gray-900 placeholder:text-gray-400 focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)]" placeholder="Search by author, title, or content" value=""/>
          </div>
        </div>

        <div class="mb-6 flex flex-wrap gap-2">
          <button class="rounded-full px-4 py-1.5 text-sm font-medium btn-primary">All</button>
          <button class="rounded-full px-4 py-1.5 text-sm font-medium btn-secondary text-gray-600 hover:bg-gray-200">Most Recent</button>
          <button class="rounded-full px-4 py-1.5 text-sm font-medium btn-secondary text-gray-600 hover:bg-gray-200">Most Liked</button>
        </div>

        <!-- Tarjeta 1 -->
        <div class="space-y-6">
          <div class="rounded-md border border-gray-200 bg-white shadow-sm">
            <div class="p-4">
              <div class="flex items-start gap-4">
                <img class="size-12 rounded-full" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBp1Q9Y7dn4w9sk8bKT_2a3m1aIf-4qUPNxiUAUhTp381sgf45vOhG2Tv27gYLXUIG-Wzu8bNCMpNxFo3Yjsu5cA-nn83e9bL7jdg9VTF9zR0aAZ52O1982Ru1KbuDRhFcfrtOVmQ-HEEMfzuuIs8dlkEW6ImDlNOLWFjhnmJmOi4YWjdvlK5IM2b-1BwXT4m6IygrAiGagALRpLAfCL7dF0eL4AoWQ84R_TAmrjR6VLyaU42Il5S67W2GnGTqYWaMhBHm0CrtJ5CA"/>
                <div class="flex-1">
                  <h3 class="text-base font-semibold text-gray-900">Community Picnic</h3>
                  <p class="text-sm text-gray-500">Posted by Sarah Miller · 2d ago</p>
                  <p class="mt-2 text-sm text-gray-700">
                    The annual community picnic will be held on Saturday, July 20th, from 12 PM to 4 PM at the central park. There will be food, games, and music. We encourage all
                    residents to attend and bring a dish to share. Please RSVP by July 15th.
                  </p>
                </div>
                <button class="text-gray-500 hover:text-gray-700">
                  <span class="material-symbols-outlined"> more_vert </span>
                </button>
              </div>
            </div>
            <div class="px-4">
              <img class="w-full rounded-lg" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB4EXbqw_z54Cx4ujW4HqEUelkl0RTYkdzaMlPefF1uCQlE_rTHQcmkIqF_GDGiOIxO_mfbQgHCIEZV5MOSs_p3O_jlnO7rbXJBZ2f7cKPbpsvTBDTcGT3ayoipYNmvV6pEGGTOon7WtEkvcCWD_Vxb37TEr8fJIPr1PreskBOf7TDsRDqCIIiniYCUHZrVif6n57plrW0fIociTLt5d0u6hLJUB4VI8ZfqRPn_4nBNrq-kieRXp18YB6Oq18aao4DOo6t0aDYpJwQ"/>
            </div>
            <div class="flex items-center gap-4 px-4 py-2">
              <button class="flex items-center gap-1.5 text-gray-500 hover:text-red-500">
                <span class="material-symbols-outlined text-xl"> favorite_border </span>
                <span class="text-sm font-medium">23</span>
              </button>
              <button class="flex items-center gap-1.5 text-gray-500 hover:text-[var(--primary-color)]">
                <span class="material-symbols-outlined text-xl"> chat_bubble_outline </span>
                <span class="text-sm font-medium">5</span>
              </button>
            </div>
            <div class="border-t border-gray-200 p-4">
              <div class="flex items-start gap-3">
                <img class="size-8 rounded-full" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC2F8AOHVuwSSCArr_qVD0Yy_bxvhSN-gQh-1Sm53-DnrORwvhX3YB1kueH-DFV9cq8vJChVoOFs3PpSrYXJ2omESr8MDuEQ4rHXhRK3L9pHuHh2dZA_uE4KDYptXwEKhdnrw_Vl3NVC7Gre81_IfbbLt8RR-M-uCbXuOSX30nAg8C4jCgaigW9VqlmiR3nIH5zVnOLfPE4XuZovwySJcUzA0nAjC0KUsZC7g4NhwDv7sTRE3MR39HQrVlaTY-sonkkWuo2QJ64HN4"/>
                <div class="flex-1">
                  <div class="flex items-baseline gap-2">
                    <p class="text-sm font-semibold text-gray-900">David Lee</p>
                    <p class="text-xs text-gray-500">1d ago</p>
                  </div>
                  <p class="text-sm text-gray-700">Looking forward to it!</p>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </main>
  </div>
</div>
</body>
</html>
