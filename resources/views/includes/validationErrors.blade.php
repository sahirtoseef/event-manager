@if (count($errors) > 0)
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endif