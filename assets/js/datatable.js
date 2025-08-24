(function ($) {
    "use strict";

    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable('#dataTable')) {
            var table = $('#dataTable').DataTable({
                lengthChange: false,
                pageLength: 10, // default awal 10 baris
                language: {
                    paginate: {
                        previous: "Prev",
                        next: "Next"
                    },
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data"
                }
            });

            /* ===== Custom dropdown length ===== */
            $('#customLength').on('change', function () {
                table.page.len($(this).val()).draw();
            });

            /* ===== Custom search ===== */
            $('#customSearch').on('keyup', function () {
                table.search(this.value).draw();
            });

            /* ===== Filter tanggal (opsional) ===== */
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


    /* =========================================
    FUNGSI: Inisialisasi DataTable dengan tombol ekspor CSV
    EVENT: Klik tombol #btnCetak untuk ekspor CSV
    ========================================= */
    $(document).ready(function () {
        // Hancurkan instance lama jika ada
        if ($.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable().destroy();
        }

        // Inisialisasi DataTable baru dengan tombol CSV
        var table = $('#dataTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'csvHtml5',
                    title: 'Laporan_Barang',
                    className: 'd-none' // tombol disembunyikan
                }
            ]
        });

        // Trigger ekspor CSV saat tombol diklik
        $('#btnCetak').on('click', function () {
            table.button('.buttons-csv').trigger();
        });
    });


})(jQuery);
