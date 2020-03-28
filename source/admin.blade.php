<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Ryan Chandler</title>
    <script src="https://identity.netlify.com/v1/netlify-identity-widget.js"></script>
</head>
<body>
    <script src="https://unpkg.com/netlify-cms@^2.0.0/dist/netlify-cms.js"></script>
    <script>
        var postPreview = createClass({
            render: function () {
                return h('div', {
                    className: 'markup'
                }, this.props.entry.widgetFor('content'))
            }
        })

        CMS.registerPreviewStyle('/assets/build/css/main.css')
        CMS.registerPreviewTemplate('posts', postPreview)
        
        if (window.netlifyIdentity) {
            window.netlifyIdentity.on("init", user => {
                if (!user) {
                    window.netlifyIdentity.on("login", () => {
                        document.location.href = "/admin/";
                    });
                }
            });
        }
    </script>
</body>
</html>