---
title: 'Deploy an AWS Lambda Function from the Terminal'
slug: deploy-an-aws-lambda-function-from-the-terminal
excerpt: 'Lambda''s GUI is perfect for toying with your function''s code, but what if you have Node dependencies or additional files you want to upload from your local machine or CI/CD? Learn how to deploy from your terminal in this article.'
published_at: 2021-02-02T11:00:00+00:00
category_slug: tips-tricks
---
My last article gave a quick run-down on [how you can invoke a Lambda function from your terminal](https://ryangjchandler.co.uk/articles/execute-an-aws-lambda-function-from-the-terminal). I've had a few people message me asking how I deploy / upload my Lambda functions to AWS.

Here is how I do it.

## Zipping up your code

When you upload your Lambda function, you'll want to provide a ZIP file that contains all of the necessary code. I mostly write Node functions these days, so my ZIP files generally contain a `node_modules` folder, an `index.js` file and a `package.json` file too so I can quickly check what dependencies I'm using from the Lambda UI.

On UNIX machines, you can use the `zip` command to generate a ZIP file. As an example, you might run something like this:

```bash
zip -r function.zip .
```

This command will create a new `function.zip` file, compressing the contents of the current directory (or `.`).

If you need to exclude some files, you can use the `-x` option. This is handy if you have a generic `input.json` or `output.json` file, as described in my [other article](https://ryangjchandler.co.uk/articles/execute-an-aws-lambda-function-from-the-terminal).

```bash
zip -r function.zip . -x output.json input.json
```

## Deploying to AWS

Now that we've got a ZIP file with our Lambda function's dependencies and handler, we can finally deploy to AWS. AWS have, surprisingly, made this very simple using the [AWS CLI](https://docs.aws.amazon.com/cli/latest/userguide/install-cliv2.html).

```bash
aws lambda update-function-code --function-name NameOfFunctionHere
```

We haven't told the AWS CLI what to deploy though. In our case it will be a ZIP file, so let's use the `--zip-file` option and specify the correct file.

```bash
aws lambda update-function-code --function-name NameOfFunctionHere --zip-file fileb://function.zip
```

The `fileb://` protocol is used because we're uploading binary data.

## Condensing this down

You might have already guessed it, but I don't actually type out this entire command each time. I like putting these commands inside of NPM "scripts" so that I can quickly run them with `npm run` or `yarn`.

```json
{
    "scripts": {
        "zip": "zip -r function.zip . -x output.json input.json",
        "deploy": "npm run zip && aws lambda update-function-code --function-name NameOfFunctionHere --zip-file fileb://function.zip"
    }
}
```