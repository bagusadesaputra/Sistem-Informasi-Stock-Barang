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

            // Tambahkan AJAX di sini agar data otomatis terisi
            $.ajax({
                url: 'functions/get_barang.php',
                type: 'GET',
                data: { barcode: kode },
                success: function(response) {
                    $('input[name="namabarang"]').val(response);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: ", error);
                }
            });

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
                url: 'functions/get_barang.php',
                type: 'GET',
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

$(document).ready(function () {
    // Cek apakah DataTable sudah ada
    if (!$.fn.DataTable.isDataTable('#dataTable')) {
        var table = $('#dataTable').DataTable({
            lengthChange: false // matikan dropdown bawaan
        });

        // Custom dropdown length
        $('#customLength').on('change', function () {
            table.page.len($(this).val()).draw();
        });

        // Custom search
        $('#customSearch').on('keyup', function () {
            table.search(this.value).draw();
        });

        // Filter tanggal
        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            var min = $('#minDate').val();
            var max = $('#maxDate').val();
            var row = table.row(dataIndex).node();
            var tgl = $(row).find('td').eq(1).data('sort');

            if (!tgl) return true;

            var date = new Date(tgl);
            var minDate = min ? new Date(min) : null;
            var maxDate = max ? new Date(max) : null;

            return (!minDate || date >= minDate) && (!maxDate || date <= maxDate);
        });

        $('#btnFilterTanggal').on('click', function () {
            table.draw();
        });
    } else {
        console.warn("DataTable sudah diinisialisasi, tidak membuat ulang.");
    }
});



})(jQuery)