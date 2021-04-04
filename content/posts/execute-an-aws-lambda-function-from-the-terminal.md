---
title: 'Execute an AWS Lambda Function from the Terminal'
slug: execute-an-aws-lambda-function-from-the-terminal
excerpt: 'Sick of manually testing your Lambda functions using the AWS interface or hitting your stage URL in Postman? Learn how to invoke / execute your function from the terminal using the AWS CLI.'
published_at: 2021-01-28T20:00:00+00:00
category_slug: tips-tricks
---
## Getting started

Before you go any further, you want to make sure you've got the AWS CLI installed. If you haven't already got it installed, you can follow the [official instructions here](https://docs.aws.amazon.com/cli/latest/userguide/install-cliv2.html).

## Generating a payload

Unfortunately, the AWS CLI can't accept the raw contents of a file as the payload when invoking a Lambda function. Instead, you need to generate a base 64 encoded version of the file.

On Unix systems, this can be done using the `base64` command. I typically store my generic payload inside of a `payload-raw.json` file and then output the base 64 encoded version to `payload.json`.

```bash
base64 payload-raw.json
```

This command will encode the raw JSON into base 64. To output the result of this command, we can just redirect `stdout` into a file.

```bash
base64 payload-raw.json > payload.json
```

## Invoke the Lambda

You can invoke your Lambda function using the `aws lambda` command. This command requires a few options so that it knows which function to execute.

```bash
aws lambda \
--function-name NameOfFunctionHere
```

If we want to send through our base 64 encoded payload, we can use the `--payload` option and specify the file that needs to be used.

```bash
aws lambda \
--function-name NameOfFunctionHere
--payload file://payload.json
```

You need to prefix the file with `file://` protocol as the AWS CLI also supports sending payloads using `http://` and `https://`.

If you want to save the output of the execution to a file, you can specify the output file at the end of the command.

```bash
aws lambda \
--function-name NameOfFunctionHere
--payload file://payload.json
output.json
```