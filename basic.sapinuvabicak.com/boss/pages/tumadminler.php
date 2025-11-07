<?php
admin_yetki($ozy, $_SESSION['departmanid'], 8); 
if (isset($_GET['temizle'])) {

    $id = temizle($_GET['temizle']);
    $sayfasil = $ozy->prepare("delete from admin where id='$id'");
    $sayfasil->execute(array($id));

    if ($sayfasil) {


        echo '<script type="text/javascript">$(document).ready(function(){toastr["success"]("Başarıyla veri silindi.", "Başarılı");});</script>';

    }


}

?>


<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Tüm Adminler</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="index.html">Anasayfa</a></li>

                        <li class="breadcrumb-item active">Adminler</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">


                        <p class="sub-title" style="text-align:right;">
                            <a href="admin-ekle" style="width: 100%;" class="btn btn-success waves-effect waves-lightt">
                                Admin Ekle
                            </a>

                        </p>

                        <table id="datatable" data-order='[[ 0, "desc" ]]'
                            class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Kullanıcı Adı</th>
                                    <th>Adı Soyadı</th>
                                    <th>Departman</th>
                                    <th>Mail</th>
                                    <th>Telefon</th>
                                    <th>Durumu</th>
                                    <th>İşlem</th>
                                </tr>
                            </thead>


                            <tbody>

                                <?php $pr = $ozy->query("SELECT a.*, d.adi as departman_adi FROM admin a 
                                    LEFT JOIN departman d ON a.departman = d.id 
                                    ORDER BY a.id DESC")->fetchAll(PDO::FETCH_ASSOC);
                                setlocale(LC_CTYPE, 'tr_TR.UTF-8');
                                foreach ($pr as $tr) { ?>


                                    <tr>
                                        <td><?php echo $tr['kullaniciadi'] ?></td>
                                        <td><?php echo $tr['adi'] . " " . $tr['soyadi'] ?>
                                        </td>
                                        <td><?php echo $tr['departman_adi'] ? $tr['departman_adi'] : 'Departman Atanmamış'; ?></td>
                                        <td><?php echo $tr['mail'] ?></td>
                                        <td><?php echo $tr['telefon'] ?></td>
                                        <td>
                                            <?php if ($tr['durum'] == '1') { ?>
                                                <span style="font-size: 13px;" class="badge badge-success">Aktif</span>
                                            <?php } else { ?>
                                                <span style="font-size: 13px;"
                                                    class="badge badge-pill badge-danger">Pasif</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <a href="tum-adminler?temizle=<?php echo $tr['id']; ?>"
                                                onclick="return confirm('Silmek istediğinize emin misiniz ?')"
                                                class="btn btn-sm btn-danger" data-toggle="tooltip"
                                                data-original-title="Sil"><i class="ti-trash" aria-hidden="true"></i></a>
                                            <a href="admin/duzenle/<?php echo $tr['id'] ?>" class="btn btn-sm btn-success"
                                                data-toggle="tooltip" data-original-title="Düzenle"><i class="fa fa-edit"
                                                    aria-hidden="true"></i></a>
                                        </td>
                                    </tr>

                                <?php } ?>




                            </tbody>
                        </table>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->


    </div>
    <!-- end container-fluid -->
</div>
<!-- end wrapper -->