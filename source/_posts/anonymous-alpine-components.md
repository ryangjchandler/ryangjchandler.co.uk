---
title: "Anonymous" Alpine Components
date: 2020-04-19
published: false
categories: [javascript]
---

How often do you _actually_ need a reactive UI for your website? I often find myself just attaching regular event listeners to certain elements on the page and doing something basic, like calling a function when a button is clicked. I don't always need the reactive, data driven features that modern frameworks provide.

Until recently, I would always just inline a `<script>` tag on the page and do all of my logic there. Inside of a Laravel project, this actually works pretty well. I don't need to use Laravel Mix, I can just use the `@stack()` and `@push()` directives in my Blade templates, and off I go.


