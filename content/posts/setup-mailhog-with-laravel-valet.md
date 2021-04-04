---
title: 'Setup MailHog with Laravel Valet'
slug: setup-mailhog-with-laravel-valet
excerpt: 'Testing emails can be a pain. Luckily, there are plenty of tools out there that can make the process a lot easier. Let me show you how to setup MailHog, a local development tool for testing emails.'
published_at: 2021-01-07T12:00:00+00:00
category_slug: tooling
---
Before we begin, you need to have **[Homebrew](https://brew.sh/)** installed. If you don't, visit [https://brew.sh/](https://brew.sh/) for instructions on how to get it installed.

If you're _not_ using Laravel Valet, you can skip the last section of this tutorial and use the `localhost` / `127.0.0.1` domain instead.

## Installing MailHog

To install MailHog, run the follow commands in your terminal:

```bash
brew install mailhog
```

This command will install MailHog on your system, but won't enable the service.

To enable the service, run the command below:

```bash
brew services start mailhog
```

This will instruct Homebrew to setup a background service so that MailHog is always running on your machine. You won't need to manually start anything, as long as Homebrew is running.

Now, you can visit 127.0.0.1:8025 in a browser and you should be greeted with the MailHog application:

![MailHog image](https://github.com/mailhog/MailHog/raw/master/docs/MailHog.png)

## Configuring your Laravel application

To get MailHog working with your Laravel application, update the following keys in your `.env` file:

```bash
MAIL_DRIVER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
```

The reason the ports are different to the MailHog UI is that the SMTP server is running on port 1025, where as the HTTP server is running on 8025.

If you send an email from your Laravel application now, you will see it pop up in the MailHog interface. You can use the code snippet below inside of Laravel Tinker to test:

```php
Mail::raw('MailHog', fn ($message) => $message->to('john@example.com')->from('laravel@example.com'));
```

## Setting up a `.test` domain

[Laravel Valet](https://laravel.com/docs/8.x/valet) makes this process super easy. All you need to do is run the following command in your terminal:

```bash
valet proxy mailhog.test http://127.0.0.1:8025
```

This command will create an Nginx configuration file for the domain `mailhog.test`, proxying all requests to that domain through to the MailHog HTTP server.

It will also setup an SSL certificate, just like `valet secure` does for your normal Laravel sites.