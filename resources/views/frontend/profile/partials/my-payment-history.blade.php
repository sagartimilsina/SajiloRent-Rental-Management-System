<!-- Payment History List -->
<div class="list-group" style="max-height:500px; overflow-y:scroll ">
    @foreach ($myPayment as $transaction_uuid => $payments)
        <div class="transaction">
            <div class="list-group-item" data-bs-toggle="modal" data-bs-target="#invoiceModal{{ $transaction_uuid }}"
                data-payment-id="{{ $transaction_uuid }}">
                <p>Transaction Code: {{ $transaction_uuid }}</p>
                <ul>
                    @foreach ($payments as $payment)
                        <div class="d-flex justify-content-between align-items-center ">
                            <div>
                                <h6>

                                    Product Name:
                                    {{ $payment->property->property_name }}
                                </h6>

                                @if ($loop->last)
                                    <p class="text-muted">
                                        Date:
                                        {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M, Y') }}<br>
                                        Payment Method: {{ $payment->payment_method }}
                                    </p>
                                @endif
                            </div>

                            @if ($loop->first)
                                <span
                                    class="badge 
                                    @if ($payment->status === 'COMPLETE') bg-success 
                                    @elseif ($payment->status === 'FAILED') bg-danger 
                                    @else bg-warning @endif text-white">
                                    {{ $payment->status }}
                                </span>
                            @endif

                        </div>
                    @endforeach
                </ul>

            </div>
        </div>

        <!-- Modal for Payment -->
        <div class="modal fade" id="invoiceModal{{ $transaction_uuid }}" tabindex="-1"
            aria-labelledby="invoiceModalLabel{{ $transaction_uuid }}" aria-hidden="true" data-bs-keyboard="false"
            data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="invoiceModalLabel{{ $transaction_uuid }}">Invoice</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center" id="invoiceContent{{ $transaction_uuid }}">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"
                            onclick="printInvoice('{{ $transaction_uuid }}')">Print Invoice</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>


</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>



<script>
    $(document).ready(function() {
        // Attach the modal event listener only once
        $('.list-group-item').on('click', function() {
            var paymentId = $(this).data('payment-id');
            var modalId = '#invoiceModal' + paymentId;
            var contentId = '#invoiceContent' + paymentId;

            // Clear previous content to show the spinner
            $(contentId).html(`
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        `);

            // Fetch invoice data via AJAX
            $.ajax({
                url: '{{ route('profile.payment.invoice', '') }}/' + paymentId,
                method: 'GET',
                success: function(response) {
                    let itemsHTML = '';
                    response.cartItems.forEach(item => {
                        itemsHTML += `
                        <tr>
                            <td>${item.property_name}</td>
                            <td>${item.property_quantity}</td>
                            <td>NPR ${item.property_price}</td>
                            <td>NPR ${(item.property_price * item.property_quantity).toFixed(2)}</td>
                        </tr>
                    `;
                    });

                    // Populate the modal content
                    $(contentId).html(`
                    <div class="invoice-container">
                        <div class="invoice-header">
                            <h1>Invoice</h1>
                            <p>Thank you for your purchase! Your invoice details are as follows:</p>
                        </div>

                        <div class="invoice-details">
                            <table>
                                <tr>
                                    <th>Invoice Number</th>
                                    <td>${response.transactionUuid}</td>
                                </tr>
                                <tr>
                                    <th>Transaction Code</th>
                                    <td>${response.transactionCode}</td>
                                </tr>
                                <tr>
                                    <th>Payment Date</th>
                                    <td>${response.paymentDate}</td>
                                </tr>
                                <tr>
                                    <th>Payment Method</th>
                                    <td>${response.paymentMethod}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>${response.status}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="invoice-items">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${itemsHTML}
                                </tbody>
                            </table>
                        </div>

                        <div class="invoice-total">
                            <p>Sub Total: NPR ${(response.totalAmount / 1.13).toFixed(2)}</p>
                            <p>Tax (13%): NPR ${(response.totalAmount - (response.totalAmount / 1.13)).toFixed(2)}</p>
                            <p class="fw-bold">Total Amount: NPR ${response.totalAmount}</p>
                        </div>
                    </div>
                `);
                },
                error: function(xhr) {
                    $(contentId).html('<p class="text-danger">Error loading invoice.</p>');
                }
            });
        });

        // AJAX pagination
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();

            var page = $(this).attr('href').split('page=')[1]; // Extract page number from URL
            loadPayments(page);
        });

        function loadPayments(page) {
            $.ajax({
                url: '?page=' + page,
                method: 'GET',
                success: function(response) {
                    // Update payment list and pagination links dynamically
                    $('.list-group').html(response.myPayment);
                    $('.pagination').html(response.pagination);
                }
            });
        }
    });


    function printInvoice() {
        const invoiceContainer = document.querySelector('.invoice-container');

        html2canvas(invoiceContainer, {
            scale: 2
        }).then((canvas) => {
            const imgData = canvas.toDataURL('image/png');

            const {
                jsPDF
            } = window.jspdf;
            const pdf = new jsPDF('p', 'mm', 'a4');

            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = pdf.internal.pageSize.getHeight();
            const imgWidth = pdfWidth;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;

            let position = 0;

            if (imgHeight <= pdfHeight) {
                pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            } else {
                while (position < imgHeight) {
                    pdf.addImage(imgData, 'PNG', 0, position - (position > 0 ? pdfHeight : 0), imgWidth,
                        imgHeight);
                    position += pdfHeight;
                    if (position < imgHeight) pdf.addPage();
                }
            }

            pdf.save('invoice.pdf');
        });
    }
</script>

<style>
    .invoice-container {
        max-width: 800px;
        margin: 0 auto;
        background: #fff;
        border: 1px solid #ddd;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .invoice-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .invoice-header h1 {
        margin: 0;
        font-size: 24px;
        color: #333;
    }

    .invoice-details,
    .invoice-items {
        margin-bottom: 10px;
    }

    .invoice-details table,
    .invoice-items table {
        width: 100%;
        border-collapse: collapse;
    }

    .invoice-details th,
    .invoice-details td,
    .invoice-items th,
    .invoice-items td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    .invoice-details th,
    .invoice-items th {
        background-color: #f5f5f5;
    }

    .invoice-total p {
        text-align: right;
        font-size: 16px;
        font-weight: bold;
    }

    @media print {

        .btn,
        .modal-footer {
            display: none !important;
        }

        .invoice-container {
            width: 100%;
            box-shadow: none;
        }
    }
</style>
