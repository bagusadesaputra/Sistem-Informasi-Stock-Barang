 (function ($) {
  "use strict";

  /* ===== FUNGSI: startScanner() ===== */
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
      $("#barcode").trigger("change");
      stopScanner();
    });
  }

  function stopScanner() {
    Quagga.stop();
    document.getElementById("scanner-container").style.display = "none";
  }

  Quagga.onDetected(function (result) {
    var kode = result.codeResult.code;
    document.getElementById("barcode").value = kode;

    $.ajax({
      url: "functions/get_barang.php",
      type: "GET",
      data: { barcode: kode },
      success: function (response) {
        $('input[name="namabarang"]').val(response);
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error: ", error);
      },
    });

    stopScanner();
  });

  $(document).ready(function () {
    $("#barcode").on("change", function () {
      var barcode = $(this).val();
      if (barcode != "") {
        $.ajax({
          url: "functions/get_barang.php",
          type: "GET",
          data: { barcode: barcode },
          dataType: "json",
          success: function (data) {
            if (data) {
              $('input[name="namabarang"]').val(data.namabarang);
              $('input[name="lokasi"]').val(data.lokasi);
              $('input[name="satuan"]').val(data.satuan);
              $("input#qty").val(data.qty); // tampil di form
              $("input#qty_hidden").val(data.qty); // input tersembunyi untuk submit
            } else {
              $('input[name="namabarang"]').val("");
              $('input[name="satuan"]').val("");
              $("input#qty").val("");
              $("input#qty_hidden").val("");
            }
          },
          error: function () {
            alert("Gagal mengambil data barang.");
          },
        });
      }
    });
  });
  /* ===== EKSPOR KE GLOBAL SCOPE ===== */
  window.startScanner = startScanner;
  window.stopScanner = stopScanner;
})(jQuery);