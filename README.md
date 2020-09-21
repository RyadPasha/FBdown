# FBdown
> PHP Video Downloader Class for Facebook. Automatically generates download links for HD and SD quality.

## Usage 
```PHP
// Include the class:
require_once 'FBDownClass.php';

// Call the FBDown class:
$FB_Down = FBDown::DL('https://www.facebook.com/RyadPasha/videos/2479123665710369');

// Print the response:
echo "<pre>";
  print_r($FB_Down);
echo "</pre>";

// Will print:
/*Array
(
    [success] => 1
    [id] => 2479123665710369
    [title] => ‪Mohamed Riyad - Sir, don't rush into anything.‬
    [desc] => Sir, don't rush into anything.
    [links] => Array
        (
            [low_quality] => https://video-hbe1-1.xx.fbcdn.net/v/t42.9040-2/77296601_485499278716576_3452479915809570816_n.mp4?_nc_cat=101&_nc_sid=985c63&efg=eyJ2ZW5jb2RlX3RhZyI6InN2ZV9zZCJ9&_nc_ohc=8rDrnrZlLhoAX-x4ukt&_nc_ht=video-hbe1-1.xx&oh=5752d189c41ef5d4841fabfb3a2f8f4c&oe=5F68AE22
            [high_quality] => https://video-hbe1-1.xx.fbcdn.net/v/t39.25447-2/10000000_313356856589618_7605993765893681189_n.mp4?_nc_cat=107&vs=159ab27924eca98&_nc_vs=HBksFQAYJEdJQ1dtQUF5LVI4VS14d0JBQ1d3N1NNSTY0MXBibWRqQUFBRhUAAsgBABUAGCRHRF9Ob2dUQ2tWOWdFZVVCQUFBQUFBQ1lEb1JrYnY0R0FBQUYVAgLIAQBLAYgScHJvZ3Jlc3NpdmVfcmVjaXBlATEVACUAHAAAGAEwFsK0l9f%2Br%2BcIFQIoAkMzGAt2dHNfcHJldmlldxwXQG4AAAAAAAAYLmRhc2hfYmFzaWNfcGFzc3Rocm91Z2hhbGlnbmVkX2hxMl9mcmFnXzJfdmlkZW8RABgYdmlkZW9zLnZ0cy5jYWxsYmFjay5wcm9kGRwVABWgtgQAKBJWSURFT19WSUVXX1JFUVVFU1QbBIgVb2VtX3RhcmdldF9lbmNvZGVfdGFnBm9lcF9oZBNvZW1fcmVxdWVzdF90aW1lX21zDTE2MDA2ODU5NzM5MzQMb2VtX2NmZ19ydWxlB3VubXV0ZWQTb2VtX3JvaV9yZWFjaF9jb3VudAYxMSw1NTYlAhwAAA%3D%3D&_nc_sid=a6057a&efg=eyJ2ZW5jb2RlX3RhZyI6Im9lcF9oZCJ9&_nc_ohc=zTcjltzVq5UAX8DfRZB&_nc_ht=video-hbe1-1.xx&oh=c667b5dc66f8ebd00bf00da123951003&oe=5F8CA26A&_nc_rid=93f23caf640d46c
        )

)*/
```

## Discussion
If you have questions or problems with installation or usage [create an Issue](https://github.com/ryadpasha/fbdown).

For any queries contact me at: **m@ryad.me**
