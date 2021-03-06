<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PS11910 | Trần Quốc Huy | LAB 03</title>
    <link rel="stylesheet" href="css/productDetail.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/cart.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <script src="javascript/back.js"></script>
    <link rel="stylesheet" href="css/products.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/box-product.css">
    <script>
        $(document).ready(function(){
            $("#btnFilters").click(function(){
            $("#wrap-filters").toggle();
            });
        });
    </script>
</head>

<body>

    <?php 
        if(isset($_GET['pId'])) {
            $id = $_GET['pId'];
            $dbh = new PDO('mysql:host=localhost;dbname=lab03db', 'root', '');
            $sql = "select * from products where pMa='$id'";
            $result=$dbh->query($sql);
            //Lấy dòng đầu tiên
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $gender = $row['pGioiTinh'];
            $price = $row['pGia'];
            $brand = $row['pHang'];
            $sqllienquan = "select * from products where pGioiTinh like '$gender' and pHang like '$brand' 
            and pGia<'$price'+1000000 and pGia>'$price'-1000000";
            $spLienQuan = $dbh->query($sqllienquan);
        }
    ?>

    <div class="container">
        <!-- Start header --> 
        <header class="header">
            <div class="rows">
                <div class="top">
                    <div class="boxcenter">
                        <div class="top-left">
                            <a href="#home"><i class="fa fa-phone-square"></i> HOTLINE: 0333 964 846</a>
                        </div>
                        <div class="top-right">
                            <a href="cart.php">
                            <?php 
                                if(isset($_SESSION['carts'])) {
                                    $tong=0;
                                    $count = count($_SESSION['carts']);
                                    foreach($_SESSION['carts'] as $cart) {
                                        $tong += $cart['price']*$cart['quantity'];
                                    }
                                    echo '<span>'.number_format($tong).' VNĐ</span>
                                        <i style="font-size: 25px;" class="fa fa-shopping-cart"></i>
                                        <span class="soluong">'.$count.'</span>
                                    ';
                                }
                                else {
                                    echo '
                                        <span>0 VNĐ</span>
                                        <i style="font-size: 25px;" class="fa fa-shopping-cart"></i>
                                        <span class="soluong">0</span>
                                    ';
                                }
                            ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rows bg-white">
                <div class="boxcenter">
                    <nav class="menu">
                        <div class="menu-left">
                            <a class="hover-effect" href="#">TOP 100</a>
                            <a class="hover-effect" href="#">THƯƠNG HIỆU</a>
                            <a class="hover-effect" href="filters.php?cId=4">NAM</a>
                            <a class="hover-effect" href="filters.php?cId=5">NỮ</a>
                            <div class="animation start-top"></div>
                        </div>
                        <div class="menu-center">
                            <div class="logo">
                                <div class="rows">
                                    <a href="index.php">
                                        <img style="position: absolute; top: 8%;" src="images/huywatch.png" alt="huywatch.com">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="menu-right">
                            <a class="hover-effect" href="#">ĐÔI</a>
                            <a class="hover-effect" href="#">TREO TƯỜNG</a>
                            <a class="hover-effect" href="#">SỮA CHỮA</a>
                            <a class="hover-effect" href="#">LIÊN HỆ</a>
                        </div>
                    </nav>
                </div>
            </div>
        </header> <!-- End header --> 

        <div class="rows ">
            <div class="title bg-white">
                <div class="boxcenter">
                    <button onclick="back()"><i style='font-size:24px' class='fas'>&#xf30a;</i></button>
                    <?php 
                        echo '<h2 style="color: #e77f67">GIỎ HÀNG</h2>';
                    ?>
                </div>
            </div>
        </div>

        
        <div class="rows">
            <div class="boxcenter">
                <div class="head">
                    <div class="left">
                        <a href="#"><i class="fa fa-fw fa-home"></i> Huywatch.com >> </a> 
                        <i class="fa fa-shopping-basket" aria-hidden="true"></i> Giỏ hàng của bạn
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div class="rows">
            <div class="boxcenter">
                
                    <?php
                        if(isset($_SESSION['carts'])) {
                        echo '<table class="giohang">';

                            echo '
                            <tr>
                                <td></td>
                                <td></td>
                                <td>SẢN PHẨM</td>
                                <td>GIÁ</td>
                                <td>Số lượng</td>
                                <td>Tổng</td>
                            </tr>
                            ';
                            foreach($_SESSION['carts'] as $cart) {
                                echo '
                                    <tr> 
                                        <td>Xóa</td>
                                        <td> <img src="images/'.$cart['image'].'" width="20%"> </td>
                                        <td>'.$cart['name'].'</td>
                                        <td>'.number_format($cart['price']).'</td>
                                        <td>'.$cart['quantity'].'</td>
                                        <td>'.number_format($cart['price']*$cart['quantity']).'</td>
                                    </tr>
                                ';
                            }
                        echo '</table>';
                        }
                        else {
                            echo '
                                <div class="empty"> 
                                    <div class="empty-img"> 
                                        <img src="images/cartempty.png" width="10%">
                                    </div>
                                    <p> Giỏ hàng đang trống </p>
                                    <a href="index.php"> Tiếp tục mua sắm </a>
                                </div>
                            ';
                        }
                    ?>
                <?php
                    if(isset($_SESSION['carts'])) {
                        $flag = count($_SESSION['carts']);
                        echo '
                        <div class="wrap-giohang">
                            <div class="giohang-tong">
                                <div class="tong-giohang">
                                    <h3>Tổng giỏ hàng</h3>
                                    <p> '.$flag.' sản phẩm </p>
                                </div>
                                <div class="tong-tien">';
                                    if(isset($_SESSION['carts'])) {
                                        $tong = 0;
                                        foreach($_SESSION['carts'] as $item) {
                                            $tong += $item['price']*$item['quantity'];
                                        }
                                        echo '<span>Thành tiền</p> 
                                                <p>'.number_format($tong).'đ</p>';
                                    }
                                echo '</div>
                            </div>

                            <div class="checkout">
                                <a href="checkout.php">Tiến hành đặt hàng</a>
                            </div>
                        </div>
                        ';
                    }
                ?>
            </div>
        </div>
        
        
        <!-- Liên kết mạng xã hội -->
        <div class="rows">
            <div class="social">
                <div class="wrap-social">
                    <div class="facebook">
                        <a href="#"><i class="fab fa-facebook-f"></i>
                        <span>Facebook</span></a>
                    </div>
                    <div class="youtube">
                        <a href="#"><i class='fab fa-youtube'></i>
                        <span>Youtube</span></a>
                    </div>
                    <div class="instagram">
                        <a href="#"><i class='fab fa-instagram'></i>
                        <span>Instagram</span></a>
                    </div>
                </div>
            </div>
        </div> <!--End Liên kết mạng xã hội-->


        <!-- Start Footer-->
        <div class="rows">
            <footer>
                <div class="boxcenter">
                    <div id="filters" class="filters" >
                        <div>
                            <h6>Sắp xếp theo</h6>
                            <a href="filters.php?cId=1">Mới nhất</a>
                            <a href="filters.php?cId=2">Giá từ thấp đến cao</a>
                            <a href="filters.php?cId=3">Giá từ cao xuống thấp</a>
                        </div>
                        <div>
                            <h6>Giới tính</h6>
                            <a href="filters.php?cId=4">Nam</a>
                            <a href="filters.php?cId=5">Nữ</a>
                        </div>
                        <div>
                            <h6>Chất liệu dây</h6>
                            <a href="filters.php?cId=6">Dây Da Bò Cao Cấp</a>
                            <a href="filters.php?cId=7">Dây Inox (Thép không gỉ)</a>
                            <a href="filters.php?cId=8">Dây Vải</a>
                            <a href="filters.php?cId=9">Dây Cao Su (Nhựa)</a>
                            <a href="filters.php?cId=10">Dây Da</a>
                            <a href="filters.php?cId=11">Dây lưới</a>
                        </div>
                        <div>
                            <h6>Loại máy</h6>
                            <a href="filters.php?cId=12">Cơ Tự Động (Automatic)</a>
                            <a href="filters.php?cId=13">Eco-drive (Năng lượng ánh sáng)</a>
                            <a href="filters.php?cId=14">Kinetic (Tự động - Pin)</a>
                            <a href="filters.php?cId=15">Pin (Quartz)</a>
                            <a href="filters.php?cId=16">Solor (Năng lượng ánh sáng mặt trời)</a>
                        </div>
                    </div>
                </div>
            </footer>
            <div class="rows">
                <div class="bottom">
                    <p>Copyright @ Tran Quoc Huy</p>
                </div>
            </div>
        </div> <!-- End Footer --> 
    </div>
</body>

</html>