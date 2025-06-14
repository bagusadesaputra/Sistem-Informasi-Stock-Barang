/*!
 * Start Bootstrap - SB Admin v6.0.2 (https://startbootstrap.com/template/sb-admin)
 * Copyright 2013-2020 Start Bootstrap
 * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
 */
(function ($) {
    "use strict";

    // Add active state to sidebar nav links
    var path = window.location.href; 
    $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function () {
        if (this.href === path) {
            $(this).addClass("active");
        }
    });

    // Toggle the side navigation
    $("#sidebarToggle").on("click", function (e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
    });

    // Fungsi Scanner Barcode
    function startScanner() {
        document.getElementById("scanner-container").style.display = "flex";
        Quagga.init(
            {
                inputStream: {
                    name: "Live",
                    type: "LiveStream",
                    target: document.querySelector("#scanner"),
                },
                decoder: {
                    readers: [
                        "code_128_reader",
                        "ean_reader",
                        "ean_8_reader",
                        "upc_reader",
                        "code_39_reader",
                    ],
                },
            },
            function (err) {
                if (err) {
                    console.log(err);
                    alert("Error: " + err);
                    return;
                }
                Quagga.start();
            }
        );

        Quagga.onDetected(function (result) {
            var kode = result.codeResult.code;
            document.getElementById("barcode").value = kode;
            stopScanner();
        });
    }

    function stopScanner() {
        Quagga.stop();
        document.getElementById("scanner-container").style.display = "none";
    }

    $('#barcode').on('change', function() {
        var barcode = $(this).val();
        if (barcode != "") {
            $.ajax({
                url: 'get_nama_barang.php',
                type: 'POST',
                data: { barcode: barcode },
                success: function(response) {
                    $('input[name="namabarang"]').val(response);
                }
            });
        } else {
            $('input[name="namabarang"]').val('');
        }
    });

    // Ekspor fungsi scanner ke global scope agar bisa dipanggil dari HTML
    window.startScanner = startScanner;
    window.stopScanner = stopScanner;

})(jQuery);