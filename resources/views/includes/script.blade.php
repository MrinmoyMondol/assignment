

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>





<script>
    $(document).ready(function() {

        //CSRF Tokens for ajax
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#contactTable').DataTable();

        // Add contact
        $('#addContactForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('contacts.store') }}",
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#addContactModal').modal('hide');
                    location.reload();
                },
                error: function(response) {
                    let errors = response.responseJSON.errors;
                    for (let error in errors) {
                        alert(errors[error]);
                    }
                }
            });
        });

        // Edit contact
        $('.edit-contact').on('click', function() {
            let id = $(this).data('id');
            $.get("{{ url('contacts') }}/" + id, function(contact) {
                $('#editContactForm input[name="name"]').val(contact.name);
                $('#editContactForm input[name="email"]').val(contact.email);
                $('#editContactForm input[name="phone"]').val(contact.phone);
                $('#editContactForm textarea[name="address"]').val(contact.address);
                $('#editContactForm').attr('action', "{{ url('contacts') }}/" + id);
                $('#editContactModal').modal('show');
            });
        });

        //Update Contact
        $('#editContactForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    $('#editContactModal').modal('hide');
                    location.reload();
                },
                error: function(response) {
                    let errors = response.responseJSON.errors;
                    for (let error in errors) {
                        alert(errors[error]);
                    }
                }
            });
        });

        // Show contact
        $('.show-contact').on('click', function() {
            let id = $(this).data('id');
            $.get("{{ url('contacts') }}/" + id, function(contact) {
                $('#showContactModal .modal-body').html(
                    '<p><strong>Name:</strong> ' + contact.name + '</p>' +
                    '<p><strong>Email:</strong> ' + contact.email + '</p>' +
                    '<p><strong>Phone:</strong> ' + contact.phone + '</p>'+
                    '<p><strong>Address:</strong> ' + contact.address + '</p>'
                );
                $('#showContactModal').modal('show');
            });
        });

        // Delete contact
        $('.delete-contact').on('click', function() {
            let id = $(this).data('id');
            if (confirm('Are you sure you want to delete this contact?')) {
                $.ajax({
                    url: "{{ url('contacts') }}/" + id,
                    method: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        location.reload();
                    }
                });
            }
        });



    });
</script>
