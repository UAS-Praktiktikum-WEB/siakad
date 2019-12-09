

<section class="content">
      <div class="container-fluid">
        <div class="row">
        <div class="app-main__inner">
                        <div class="app-page-title">
                            <div class="page-title-wrapper">
                                <div class="page-title-heading">
                                    <div class="page-title-icon">
                                        <i class="pe-7s-drawer icon-gradient bg-happy-itmeo">
                                        </i>
                                    </div>
                                    <div>Regular Tables
                                        <div class="page-title-subheading">Tables are the backbone of almost all web applications.
                                        </div>
                                    </div>
                                </div>
                                <div class="page-title-actions">                                    
                                    <div class="d-inline-block dropdown">
                                        <button type="button" class="btn-shadow btn btn-primary" onclick="add_mahasiswa()"><i class='fa fa-plus-circle'></i>Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>            
                        <div class="col-lg-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Table striped</h5>
                                        
                                        <table id="table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                            <thead>
                                            	<tr>
													<th>No</th>
													<th>NPM</th>							
													<th>Nama</th>
													<th>Alamat</th>
													<th>Tempat Lahir</th>
													<th>Tanggal Lahir</th>
													<th>Program Studi</th>
													<th width="20">Aksi</th>							
												</tr>
											</thead>
											<tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="app-wrapper-footer">
                        <div class="app-footer">
                            <div class="app-footer__inner">
                                <div class="app-footer-left">
                                    <ul class="nav">
                                        <li class="nav-item">
                                            <a href="javascript:void(0);" class="nav-link">
                                                Footer Link 1
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void(0);" class="nav-link">
                                                Footer Link 2
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="app-footer-right">
                                    <ul class="nav">
                                        <li class="nav-item">
                                            <a href="javascript:void(0);" class="nav-link">
                                                Footer Link 3
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void(0);" class="nav-link">
                                                <div class="badge badge-success mr-1 ml-0">
                                                    <small>NEW</small>
                                                </div>
                                                Footer Link 4
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> 
<script>
var table;
var save_method;

$(document).ready(function() {
    show_datatables(); 
    pick_tanggal();     
});

function show_datatables()
{
	table = $('#table').DataTable({ 
		"fixedHeader": true,		
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('mahasiswa/ajax_list')?>",
            "type": "POST"	
        },
				
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column
            "orderable": false, //set not orderable
        },
        ],
		"destroy" : true		
	});		
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function reset_eror()
{
    $('#npm_error').html('');
    $('#nama_error').html('');
    $('#program_studi_error').html('');
    $('#btnSave').attr('disabled',false);
}

function add_mahasiswa()
{
    save_method = 'add';
    reset_eror();
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
    $('.modal-title').text('Tambah Mahasiswa'); // Set title to Bootstrap modal title   
}

function edit_mahasiswa(id)
{
    save_method = 'update';
    reset_eror();
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
 
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('mahasiswa/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="hnpm"]').val(data.npm);
            $('[name="npm"]').val(data.npm);
            $('[name="nama"]').val(data.nama);
            $('[name="alamat"]').val(data.alamat);
            $('[name="tempat_lahir"]').val(data.tempat_lahir);
            $('[name="tgl_lahir"]').val(data.tgl_lahir);
            $('[name="program_studi"]').val(data.program_studi);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Mahasiswa'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function view_mahasiswa(id)
{
    save_method = 'update';
    reset_eror();
    $('#btnSave').attr('disabled',true);
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
 
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('mahasiswa/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="npm"]').val(data.npm);
            $('[name="nama"]').val(data.nama);
            $('[name="alamat"]').val(data.alamat);
            $('[name="tempat_lahir"]').val(data.tempat_lahir);
            $('[name="tgl_lahir"]').val(data.tgl_lahir);
            $('[name="program_studi"]').val(data.program_studi);          
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('View Mahasiswa'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;
 
    if(save_method == 'add') {
        url = "<?php echo site_url('mahasiswa/ajax_add')?>";
    } else {
        url = "<?php echo site_url('mahasiswa/ajax_update')?>";
    }
 
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        { 
            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            } else {
                $('#npm_error').html(data.npm_error);
                $('#nama_error').html(data.nama_error);
                $('#program_studi_error').html(data.program_studi_error);
            }

            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            //alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
 
        }
    });     
}

function delete_mahasiswa(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('mahasiswa/ajax_delete/')?>"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
 
    }
}
</script>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>