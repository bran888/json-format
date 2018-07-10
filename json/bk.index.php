<html>
    <head>
        <meta charset="utf-8" />
 
        <title>hello</title>
 
        <style>
            pre {outline: 1px solid #ccc; padding: 5px; margin: 5px; }
            .string { color: green; }
            .number { color: darkorange; }
            .boolean { color: blue; }
            .null { color: magenta; }
            .key { color: red; }
        </style>
        <script type="text/javascript">
        function syntaxHighlight(json) {
            if (typeof json != 'string') {
                json = JSON.stringify(json, undefined, 2);
            }
            json = json.replace(/&/g, '&').replace(/</g, '<').replace(/>/g, '>');
            return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function(match) {
                var cls = 'number';
                if (/^"/.test(match)) {
                    if (/:$/.test(match)) {
                        cls = 'key';
                    } else {
                        cls = 'string';
                    }
                } else if (/true|false/.test(match)) {
                    cls = 'boolean';
                } else if (/null/.test(match)) {
                    cls = 'null';
                }
                return '<span class="' + cls + '">' + match + '</span>';
            });
        }
 
    </script>
    </head>
    <body>
 
    <pre id="result">
 
    </pre>
    <script type="text/javascript">
        var songResJson={ 
              "service": "ALL", 
              "qt": 581, 
              "content": { 
                "answer": { 
                  "song": "如果缘只到遇见", 
                  "album": "如果缘只到遇见", 
                  "artist": "吴奇隆 严艺丹", 
                  "pic_url": "http://p1.music.126.net/-u3WgIXsFNCW7d8Jy7pCEA==/5921969627395387.jpg" 
                }, 
                "scene": "music" 
              } 
            }
            document.getElementById('result').innerHTML = syntaxHighlight(songResJson);
 
        // $('#result').html(syntaxHighlight(songResJson));
    </script>
     
    </body>
</html>
