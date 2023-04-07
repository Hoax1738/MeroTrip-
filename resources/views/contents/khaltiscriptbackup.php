<script src="https://khalti.com/static/khalti-checkout.js"></script>

    <script type="text/javascript">
        var config = {
            "publicKey": "test_public_key_dc74e0fd57cb46cd93832aee0a507256",
            "productIdentity": document.getElementById("productID").value,
            "productName": document.getElementById("productName").value,
            "productUrl": document.getElementById("productURL").value,
            "eventHandler": {
                onSuccess (payload) {
                    document.getElementById("payment_data").value = JSON.stringify(payload);
                    document.getElementById('paymentForm').submit();
                },
                onError (error) {},
                onClose () {}
            }
        };

        var checkout = new KhaltiCheckout(config);
        var btn = document.getElementById("payment-button");
        btn.onclick = function () {
            checkout.show({amount: (document.getElementById("amount").value*100)});
        }
    </script>