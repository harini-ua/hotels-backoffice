$(document).ready(function () {

    const generate = $("#generate");
    const pattern = /[a-zA-Z0-9_\-\+\.]/
    generate.on('click', function(e) {
        document.getElementById("password").value = Array.apply(null, {'length': 10})
            .map(function()
            {
                var result;

                while(true)
                {
                    result = String.fromCharCode(_getRandomByte());
                    if(pattern.test(result))
                    {
                        return result;
                    }
                }
            }, this)
            .join('')
    });

    function _getRandomByte()
    {
        if(window.crypto && window.crypto.getRandomValues)
        {
            var result = new Uint8Array(1);

            window.crypto.getRandomValues(result);

            return result[0];
        }
        else if(window.msCrypto && window.msCrypto.getRandomValues)
        {
            var result = new Uint8Array(1);

            window.msCrypto.getRandomValues(result);

            return result[0];
        }
        else
        {
            return Math.floor(Math.random() * 256);
        }
    }
});
