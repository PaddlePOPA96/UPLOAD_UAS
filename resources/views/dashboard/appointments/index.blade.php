@extends('dashboard.layouts.main')


@section('container')

    <div class="container-fluid py-5">

        <div class="d-flex justify-content-between mb-4">
            <h2>Daftar Appointment | tanggal {{ date('Y-m-d') }}</h2>

            <a href="{{ route('appointments.create') }}" class="btn btn-primary">Create Appointment</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped mb-0 bg-white"
            id="appointmentTable">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Category</th>
                        <th>Appointment Date</th>
                        <th>Message</th>
                        <th>Actions</th>
                        <th>Reminder</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $appointment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $appointment->name }}</td>
                            <td>{{ $appointment->email }}</td>
                            <td>{{ $appointment->phone_number }}</td>
                            <td>{{ $appointment->category->title }}</td>
                            <td>{{ $appointment->diffInDays }} Hari Lagi</td>
                            <td>{{ $appointment->message }}</td>
                            <td>
                                <a href="{{ route('appointments.show', $appointment->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-sm btn-primary">Edit</a>

                                <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger btn-delete"
                                        onclick="return confirm('Are you sure you want to delete this appointment?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                            <td>
                                @php
                                $whatsappMessage = "Hallo Sobat GIGIKU " . $appointment->name . ", kami dari admin gigiku mau mengingatkan kalau appointment anda : " . $appointment->diffInDays . " hari lagi.
                                Ingat permasalahan gigi ingat GIGIKU ";
                                $whatsappNumber = $appointment->phone_number;
                                $whatsappUrl = "https://wa.me/" . $whatsappNumber . "?text=" . urlencode($whatsappMessage);
                            @endphp
                            <a href="{{ $whatsappUrl }}" class="btn btn-sm btn-success" target="_blank">Send Reminder</a>

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection



@push('scripts')
    <script type="module">
        $(document).ready(function() {
            $('#appointmentTable').DataTable();

            $(".datatable").on("click", ".btn-delete", function (e) {
                e.preventDefault();
                var form = $(this).closest("form");
                var name = $(this).data("name");
                Swal.fire({
                    title: "Are you sure want to delete\n" + name + "?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "bg-primary",
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush