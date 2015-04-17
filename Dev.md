Anonymous uploads to AWS S3
===========================

This guide explains how to upload file data over HTTP using JavaScript to perform the HTTP request and PHP to perform the signing process, although any server-side language can be used to sign the HTML form.

The initial step is to create an HTML form with the following fields:

+ AWSAccessKeyId - This is the public access key ID of the IAM user that owns the s3 bucket.
+ acl - TODO: Explain.
+ key - The name of the file, after upload. You can call the file whatever you want here, or use `${filename}` as the value to use the name of the uploaded file.
+ policy - TODO: Explain.
+ signature - TODO: Explain.
+ file - The actual file input element.


Step 1: Create your HTML form
-----------------------------

