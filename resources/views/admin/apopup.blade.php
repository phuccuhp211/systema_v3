@if ($mng == "sections")
	<div class="bg-add hide-bg-add">
		<div class="af-mng">
			<form action="{{ route('manager.ss',['type' => 'add']) }}" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="col-6">
						<div class="field-add">
							<label>Tên Section :</label>
							<input type="text" name="name">
						</div>
						<div class="db-field-add">
	                        <div class="field-add">
	                            <label>Phân Loại :</label>
	                            <select name="phanloai">
	                            	<option value="0">Không Chọn</option>
	                            	<?php foreach ($cat1 as $value => $item) {
	                            		echo "<option value=\"".$item['id']."\">".$item['name']."</option>";
	                            	} ?>
	                            </select>
	                        </div>
	                        <div class="field-add">
	                            <label>Danh Mục :</label>
	                            <select name="danhmuc">
	                            	<option value="0">Không Chọn</option>
	                            	<?php foreach ($cat2 as $value => $item) {
	                            		echo "<option value=\"".$item['id']."\">".$item['name']."</option>";
	                            	} ?>
	                            </select>
	                        </div>        
	                    </div>
	                    <div class="db-field-add">
	                        <div class="field-add">
	                            <label>Mục Tham Chiếu :</label>
	                            <select name="ref">
	                            	<option value="id">ID</option>
	                            	<option value="name">Tên</option>
	                            	<option value="price">Giá</option>
	                            	<option value="price_sale">Khuyến Mãi</option>
	                            	<option value="viewed">Lượt Xem</option>
	                            	<option value="saled">S.Lượng Đã Bán</option>
	                            </select>
	                        </div>
	                        <div class="field-add">
	                            <label>Sắp Xếp Theo :</label>
	                            <select name="ord">
	                            	<option value="1">A-Z 0-9</option>
	                            	<option value="2">Z-A 9-0</option>
	                            	<option value="3">Ngẫu Nhiên</option>
	                            </select>
	                        </div>        
	                    </div>
					</div>
					<div class="col-6">
						<div class="field-add">
                            <label>Poster :</label>
                            <input type="file" name="poster">
                        </div>
                        <div class="field-add">
                            <label>Ảnh Nền :</label>
                            <input type="file" name="backgr">
                        </div>  
                        <div class="field-add">
	                        <label>Vị Trí :</label>
	                        <input type="number" min="1" name="position">
	                    </div>    
					</div>
				</div>
				<div class="field-add">
					<button class="btn btn-success" type="submit">Thêm Section</button>
				</div>
			</form>
			<div class="field-add" style="margin:0;">
				<button class="btn btn-danger quaylai">Quay Lại</button>
			</div>
		</div>
	</div>
	<div class="bg-fix hide-bg-fix">
		<div class="af-mng">
			<form action="{{ route('manager.ss',['type' => 'fix']) }}" method="POST" enctype="multipart/form-data" id="form_fix_bc">
				<div class="row">
					<div class="col-6">
						<div class="field-add">
							<label>Tên Section :</label>
							<input type="text" name="name" id="fix_name_bc">
						</div>
						<div class="db-field-add">
	                        <div class="field-add">
	                            <label>Phân Loại :</label>
	                            <select name="phanloai" id="fix_pl_bc">
	                            	<option value="0">Không Chọn</option>
	                            	<?php foreach ($cat1 as $value => $item) {
	                            		echo "<option value=\"".$item['id']."\">".$item['name']."</option>";
	                            	} ?>
	                            </select>
	                        </div>
	                        <div class="field-add">
	                            <label>Danh Mục :</label>
	                            <select name="danhmuc" id="fix_dm_bc">
	                            	<option value="0">Không Chọn</option>
	                            	<?php foreach ($cat2 as $value => $item) {
	                            		echo "<option value=\"".$item['id']."\">".$item['name']."</option>";
	                            	} ?>
	                            </select>
	                        </div>        
	                    </div>
	                    <div class="db-field-add">
	                        <div class="field-add">
	                            <label>Mục Tham Chiếu :</label>
	                            <select name="ref" id="fix_ref_bc">
	                            	<option value="id">ID</option>
	                            	<option value="name">Tên</option>
	                            	<option value="price">Giá</option>
	                            	<option value="price_sale">Khuyến Mãi</option>
	                            	<option value="viewed">Lượt Xem</option>
	                            	<option value="saled">S.Lượng Đã Bán</option>
	                            </select>
	                        </div>
	                        <div class="field-add">
	                            <label>Sắp Xếp Theo :</label>
	                            <select name="ord" id="fix_ord_bc">
	                            	<option value="1">A-Z 0-9</option>
	                            	<option value="2">Z-A 9-0</option>
	                            	<option value="3">Ngẫu Nhiên</option>
	                            </select>
	                        </div>        
	                    </div>
					</div>
					<div class="col-6">
						<div class="field-add">
                            <label>Poster :</label>
                            <input type="file" name="poster">
                            <input type="text" name="old_img1" id="fix_pos_bc" hidden>
                        </div>
                        <div class="field-add">
                            <label>Ảnh Nền :</label>
                            <input type="file" name="backgr">
                            <input type="text" name="old_img2" id="fix_bgr_bc" hidden>
                        </div>  
                        <div class="field-add">
	                        <label>Vị Trí :</label>
	                        <input type="number" min="1" name="position" id="fix_num_bc">
	                    </div>    
					</div>
				</div>
				<div class="field-add">
					<button class="btn btn-success" type="submit">Sửa Section</button>
				</div>
			</form>
			<div class="field-add" style="margin:0;">
				<button class="btn btn-danger quaylai">Quay Lại</button>
			</div>
		</div>
	</div>
	<div class="bg-del hide-bg-del">
		<div class="del-mng">
			<div class="field-add">
				<h4 class="text-center">Bạn có chắc muốn xóa Section ?</h4 class="text-center">
			</div>
			<div class="field-add">
				<a href="{{ route('manager.ss',['type' => 'del']) }}" class="btn btn-success" id="acp-del" type="submit">Xóa</a>
			</div>
			<button class="btn btn-danger quaylai" type="submit">Quay Lại</button>
		</div>
	</div>

@elseif ($mng == "slidebns")
	<div class="bg-add hide-bg-add">
		<div class="af-mng">
			<form action="{{ route('manager.bn',['type' => 'add']) }}" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="field-add">
						<label>Tiêu Đề :</label>
						<input type="text" name="ttbn">
					</div>
					<div class="field-add">
						<label>Đoạn Văn Bản :</label>
						<textarea name="txbn"></textarea>
					</div>
					<div class="field-add">
	                    <label>Banner :</label>
	                    <input type="file" name="img">
	                </div>
				</div>
				<div class="field-add">
					<button class="btn btn-success" type="submit">Thêm Banner</button>
				</div>
			</form>
			<div class="field-add" style="margin:0;">
				<button class="btn btn-danger quaylai">Quay Lại</button>
			</div>
		</div>
	</div>
	<div class="bg-fix hide-bg-fix">
		<div class="af-mng">
			<form action="{{ route('manager.bn',['type' => 'fix']) }}" method="POST" enctype="multipart/form-data" id="form_fix_bn">
				<div class="row">
					<div class="field-add">
						<label>Tiêu Đề :</label>
						<input type="text" name="ttbn" id="fix_tt_bn">
					</div>
					<div class="field-add">
						<label>Đoạn Văn Bản :</label>
						<textarea name="txbn" id="fix_tx_bn"></textarea>
					</div>
					<div class="field-add">
	                    <label>Banner : (Không chọn nếu sử dụng ảnh cũ)</label>
	                    <input type="file" name="img">
	                    <input type="text" name="old_img" hidden id="fix_img_bn">
	                </div>
				</div>
				<div class="field-add">
					<button class="btn btn-success" type="submit">Sửa Banner</button>
				</div>
			</form>
			<div class="field-add" style="margin:0;">
				<button class="btn btn-danger quaylai">Quay Lại</button>
			</div>
		</div>
	</div>
	<div class="bg-del hide-bg-del">
		<div class="del-mng">
			<div class="field-add">
				<h4 class="text-center">Bạn có chắc muốn xóa Banner ?</h4 class="text-center">
			</div>
			<div class="field-add">
				<a href="{{ route('manager.bn',['type' => 'del']) }}" class="btn btn-success" id="acp-del" type="submit">Xóa</a>
			</div>
			<button class="btn btn-danger quaylai" type="submit">Quay Lại</button>
		</div>
	</div>

@elseif ($mng == "products")
	<div class="bg-add hide-bg-add">
		<div class="af-mng">
			<h3 class="text-center">Thêm Sản Phẩm</h3>
			<form action="{{ route('manager.pd',['type' => 'add']) }}" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="col-6">
						<div class="field-add">
							<label>Tên Sản Phẩm :</label>
							<input type="text" name="name">
						</div>
						<div class="db-field-add">
							<div class="field-add">
								<label>Danh Mục :</label>
								<select name="catalog" id="">
									<option value=""></option>
									<?php foreach ($cat2 as $value => $item) { ?>
										<option value="<?php echo $item['id'] ?>"><?php echo $item['name'] ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="field-add">
								<label>Thương Hiệu :</label>
								<select name="brand" id="">
									<option value=""></option>
									<?php foreach ($brands as $value => $item) { ?>
										<option value="<?php echo $item['id_brand'] ?>"><?php echo $item['name'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="field-add">
							<label>Phân Loại :</label>
							<select name="pdtype" id="">
								<option value=""></option>
								<?php foreach ($cat1 as $value => $item) { ?>
									<option value="<?php echo $item['id'] ?>"><?php echo $item['name'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-6">
						<div class="db-field-add">
							<div class="field-add">
								<label>Giá Sản Phẩm :</label>
								<input type="number" name="price">
							</div>
							<div class="field-add">
								<label>Giá Sale (nếu có) :</label>
								<input type="number" name="sale">
							</div>
						</div>
						<div class="db-field-add">
							<div class="field-add">
								<label>Sale từ ngày (nếu có) :</label>
								<input type="date" name="salef">
							</div>
							<div class="field-add">
								<label>Sale đến ngày (nếu có) :</label>
								<input type="date" name="salet">
							</div>
						</div>
						<div class="field-add">
							<label>Mô tả :</label>
							<input type="text" name="info">
						</div>
					</div>
					<div class="col-12">
						<div class="field-add">
							<label>Thông tin chi tiết :</label>
							<textarea name="detail" id="ttct-sp"></textarea>
						</div>
						<div class="field-add">
							<label style="width:auto; margin: 0 30px 0 0;">Hình ảnh :</label>
							<input type="file" name="img">
						</div>
					</div>
					<div class="col-12">
						<button class="btn btn-success" type="submit">Thêm Sản Phẩm</button>
					</div>
				</div>
			</form><hr>
			<div class="field-add" style="margin:0;">
				<button class="btn btn-danger quaylai">Quay Lại</button>
			</div>
		</div>
	</div>
	<div class="bg-fix hide-bg-fix">
		<div class="af-mng">
			<h3 class="text-center">Sửa Sản Phẩm</h3>
			<form action="{{ route('manager.pd',['type' => 'fix']) }}" method="POST" enctype="multipart/form-data" id="form_fix_pro">
				<div class="row">
					<div class="col-6">
						<div class="field-add">
							<label>Tên Sản Phẩm :</label>
							<input type="text" name="name" id="fix_name_sp">
						</div>
						<div class="db-field-add">
							<div class="field-add">
								<label>Danh Mục :</label>
								<select name="catalog" id="fix_catalog_sp">
									<option value=""></option>
									<?php foreach ($cat2 as $value => $item) { ?>
										<option value="<?php echo $item['id'] ?>"><?php echo $item['name'] ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="field-add">
								<label>Thương Hiệu :</label>
								<select name="brand" id="fix_brand_sp">
									<option value=""></option>
									<?php foreach ($brands as $value => $item) { ?>
										<option value="<?php echo $item['id_brand'] ?>"><?php echo $item['name'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="field-add">
							<label>Phân Loại :</label>
							<select name="pdtype" id="fix_pl_sp">
								<option value="" ></option>
								<?php foreach ($cat1 as $value => $item) { ?>
									<option value="<?php echo $item['id'] ?>"><?php echo $item['name'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-6">
						<div class="db-field-add">
							<div class="field-add">
								<label>Giá Sản Phẩm :</label>
								<input type="number" name="price" id="fix_price_sp">
							</div>
							<div class="field-add">
								<label>Giá Sale (nếu có) :</label>
								<input type="number" name="sale" id="fix_sale_sp">
							</div>
						</div>
						<div class="db-field-add">
							<div class="field-add">
								<label>Sale từ ngày (nếu có) :</label>
								<input type="date" name="salef" id="fix_salef_sp">
							</div>
							<div class="field-add">
								<label>Sale đến ngày (nếu có) :</label>
								<input type="date" name="salet" id="fix_salet_sp">
							</div>
						</div>
						<div class="field-add">
							<label>Mô tả :</label>
							<input type="text" id="fix_info_sp" name="info">
						</div>
					</div>
					<div class="col-12">
						<div class="field-add">
							<label>Thông tin chi tiết :</label>
							<textarea name="detail" id="ttct-sp"></textarea>
						</div>
						<div class="field-add">
							<label style="width:auto; margin: 0 30px 0 0;">Hình ảnh ( không chọn nếu sử dụng ảnh cũ ) :</label>
							<input type="file" name="img">
							<input type="text" name="old_img" id="fix_img_sp" hidden>
						</div>
					</div>
					<div class="col-12">
						<button class="btn btn-success" type="submit">Cập Nhật Sản Phẩm</button>
					</div>
				</div>
			</form><hr>
			<div class="field-add" style="margin:0;">
				<button class="btn btn-danger quaylai">Quay Lại</button>
			</div>
		</div>
	</div>
	<div class="bg-del hide-bg-del">
		<div class="del-mng">
			<div class="field-add">
				<h4 class="text-center">Bạn có chắc muốn xóa sản phẩm ?</h4 class="text-center">
			</div>
			<div class="field-add">
				<a href="{{ route('manager.pd',['type' => 'del']) }}" class="btn btn-success" id="acp-del" type="submit">Xóa</a>
			</div>
			<button class="btn btn-danger quaylai" type="submit">Quay Lại</button>
		</div>
	</div>
	<div class="popup-small hide-popup">
		<i class="fa-solid fa-eye-slash"></i>
		<span>Đã Ẩn Sản Phẩm</span>
	</div>

@elseif ($mng == "catalogs")
	<div class="bg-add hide-bg-add">
		<div class="af-mng">
			<div class="row">
				<div class="col-6">
					<form action="{{ route('manager.c2',['type' => 'add']) }}" method="POST" enctype="multipart/form-data">
						<h3 class="text-center">Thêm Danh Mục</h3>
						<div class="db-field-add">
							<div class="field-add">
								<label>Tên Danh Mục :</label>
								<input type="text" name="name">
							</div>
							<div class="field-add">
								<label>Mã Phân Loại</label>
								<select name="phanloai" id="pl">
									<?php foreach ($list1 as $value => $item) { ?>
										<option value="<?php echo $item['id'] ?>">Mã : <?php echo $item['id'] ?> | <?php echo $item['name'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="field-add">
							<label style="width: auto;">IMG (nếu có) :</label>
							<input type="file" name="img">
						</div>
						<div class="field-add">
							<button class="btn btn-success" type="submit">Thêm Danh Mục</button>
						</div>
					</form>
				</div>
				<div class="col-6">
					<form action="{{ route('manager.c1',['type' => 'add']) }}" method="POST" enctype="multipart/form-data">
						<h3 class="text-center">Thêm Phân Loại</h3>
						<div class="field-add">
							<label>Tên Phân Loại :</label>
							<input type="text" name="name">
						</div>
						<div class="field-add">
							<button class="btn btn-success" type="submit">Thêm Phân Loại</button>
						</div>
					</form>
				</div>
			</div>			
			<div class="field-add" style="margin:0;">
				<button class="btn btn-danger quaylai">Quay Lại</button>
			</div>
		</div>
	</div>
	<div class="bg-fix hide-bg-fix">
		<div class="af-mng">
			<div class="row">
				<div class="col-6">
					<form action="{{ route('manager.c2',['type' => 'add']) }}" method="POST" enctype="multipart/form-data" id="form_fix_cat">
						<h3 class="text-center">Cập Nhật Danh Mục</h3>
						<div class="db-field-add">
							<div class="field-add">
								<label>Tên Danh Mục :</label>
								<input type="text" name="name" id="fix_name_dm">
							</div>
							<div class="field-add">
								<label>Mã Phân Loại</label>
								<select name="phanloai" id="fix_name_pldm">
									<?php foreach ($list1 as $value => $item) { ?>
										<option value="<?php echo $item['id'] ?>">Mã : <?php echo $item['id'] ?> | <?php echo $item['name'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="field-add">
							<label style="width:auto; margin: 0 30px 0 0;">IMG (nếu có) :</label>
							<input type="file" name="img" id="fix_img_dm">
							<input type="text" name="old_img" id="fix_img_dm" hidden>
						</div>
						<div class="field-add">
							<button class="btn btn-success" type="submit">Cập Nhật Danh Mục</button>
						</div>
					</form>
				</div>
				<div class="col-6">
					<form action="{{ route('manager.c1',['type' => 'add']) }}" method="POST" enctype="multipart/form-data" id="form_fix_pl">
						<h3 class="text-center">Cập Nhật Phân Loại</h3>
						<div class="field-add">
							<label>Tên Phân Loại :</label>
							<input type="text" name="name" id="fix_name_pl">
						</div>
						<div class="field-add">
							<button class="btn btn-success" type="submit">Cập Nhật Phân Loại</button>
						</div>
					</form>
				</div>
			</div>
			<div class="field-add" style="margin:0;">
				<button class="btn btn-danger quaylai">Quay Lại</button>
			</div>
		</div>
	</div>
	<div class="bg-del hide-bg-del">
		<div class="del-mng">
			<div class="field-add">
				<h4 class="text-center">Bạn có chắc muốn xóa danh mục ?</h4 class="text-center">
			</div>
			<div class="field-add">
				<a href="" class="btn btn-success" id="acp-del" type="submit">Xóa</a>
			</div>
			<button class="btn btn-danger quaylai" type="submit">Quay Lại</button>
		</div>
	</div>

@elseif ($mng == "usersmng")
	<div class="bg-add hide-bg-add">
		<div class="af-mng">
			<form action="{{ route('manager.us',['type' => 'add']) }}" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="col-6">
						<div class="field-add">
							<label>Tên Tài Khoản :</label>
							<input type="text" name="name">
						</div>
						<div class="db-field-add">
	                        <div class="field-add">
	                            <label>Họ :</label>
	                            <input type="text" name="ho">
	                        </div>
	                        <div class="field-add">
	                            <label>Tên :</label>
	                            <input type="text" name="ten">
	                        </div>        
	                    </div>
	                    <div class="field-add">
							<label style="width:auto; margin: 0 30px 0 0;">Role :</label>
							<select name="role" id="">
								<option value="0">Admin</option>
								<option value="1">User</option>
							</select>
						</div>
					</div>
					<div class="col-6">
						<div class="field-add">
                            <label>Email :</label>
                            <input type="text" name="email">
                        </div>
                        <div class="field-add">
                            <label>Số điện thoại :</label>
                            <input type="number" name="phone">
                        </div>  
                        <div class="field-add">
	                        <label>Địa chỉ :</label>
	                        <input type="text" name="diachi">
	                    </div>    
					</div>
				</div>
				<div class="field-add">
					<label style="width:auto; margin: 0 30px 0 0;">Mật Khẩu :</label>
					<input type="password" name="pass">
				</div>
				<div class="field-add">
					<button class="btn btn-success" type="submit">Thêm Người Dùng</button>
				</div>
			</form>
			<div class="field-add" style="margin:0;">
				<button class="btn btn-danger quaylai">Quay Lại</button>
			</div>
		</div>
	</div>
	<div class="bg-fix hide-bg-fix">
		<div class="af-mng">
			<form action="{{ route('manager.us',['type' => 'fix']) }}" method="POST" enctype="multipart/form-data" id="form_fix_us">
				<div class="row">
					<div class="col-6">
						<div class="field-add">
							<label>Tên Tài Khoản :</label>
							<input type="text" name="name" id="name_fix_us">
						</div>
						<div class="db-field-add">
	                        <div class="field-add">
	                            <label>Họ :</label>
	                            <input type="text" name="ho" id="ho_fix_us">
	                        </div>
	                        <div class="field-add">
	                            <label>Tên :</label>
	                            <input type="text" name="ten" id="ten_fix_us">
	                        </div>        
	                    </div>
	                    <div class="field-add">
							<label style="width:auto; margin: 0 30px 0 0;">Role :</label>
							<select name="role" id="role_fix_us">
								<option value="0">0</option>
								<option value="1">1</option>
							</select>
						</div>
					</div>
					<div class="col-6">
						<div class="field-add">
                            <label>Email :</label>
                            <input type="text" name="email" id="email_fix_us">
                        </div>
                        <div class="field-add">
                            <label>Số điện thoại :</label>
                            <input type="number" name="phone" id="phone_fix_us">
                        </div>  
	                    <div class="field-add">
	                        <label>Địa chỉ :</label>
	                        <input type="text" name="diachi">
	                    </div>
					</div>
				</div>
				<div class="field-add">
					<label style="width:auto; margin: 0 30px 0 0;">Mật Khẩu :</label>
					<input type="password" name="pass">
				</div>
						
				<div class="field-add">
					<button class="btn btn-success" type="submit">Cập Nhật</button>
				</div>
			</form>
			<div class="field-add" style="margin:0;">
				<button class="btn btn-danger quaylai">Quay Lại</button>
			</div>
		</div>
	</div>
	<div class="bg-del hide-bg-del">
		<div class="del-mng">
			<div class="field-add">
				<h4 class="text-center">Bạn có chắc muốn xóa người dùng ?</h4 class="text-center">
			</div>
			<div class="field-add">
				<a href="{{ route('manager.us',['type' => 'del']) }}" class="btn btn-success" id="acp-del" type="submit">Xóa</a>
			</div>
			<button class="btn btn-danger quaylai" type="submit">Quay Lại</button>
		</div>
	</div>
	<div class="popup-small hide-popup">
		<i class="fa-solid fa-ban"></i>
		<span>Đã Khóa Tài Khoản</span>
	</div>

@elseif ($mng == "comments")
	<div class="bg-del hide-bg-del">
		<div class="del-mng">
			<div class="field-add">
				<h4 class="text-center">Bạn có chắc muốn xóa bình luận này ?</h4 class="text-center">
			</div>
			<div class="field-add">
				<a href="{{ route('manager.cm',['type' => 'del']) }}" class="btn btn-success" id="acp-del" type="submit">Xóa</a>
			</div>
			<button class="btn btn-danger quaylai" type="submit">Quay Lại</button>
		</div>
	</div>
	<div class="bg-inf hide-bg-inf">
		<div class="dsbl">
			<table style="width: 100%; margin: 15px 0 30px;" id="list-bl-start">
				<tr>
					<th style="width: auto;">Nội dung</th>
					<th style="width: 70px;">ID User</th>
					<th style="width: 120px;">Ngày</th>
					<th style="width: 70px;">Xóa</th>
				</tr>
			</table>
			<button class="btn btn-danger qlai" type="submit">Quay Lại</button>
		</div>
	</div>

@elseif ($mng == "offers")
	<div class="bg-add hide-bg-add">
		<div class="af-mng">
			<form action="{{ route('manager.cp',['type' => 'add']) }}" method="POST" enctype="multipart/form-data">
				<div class="field-add">
					<label>Nhập tên mã :</label>
					<input type="text" name="name">
				</div>
				<div class="db-field-add">
                    <div class="field-add">
                        <label>Từ ngày :</label>
                        <input type="date" name="fd">
                    </div>
                    <div class="field-add">
                        <label>Đến ngày :</label>
                        <input type="date" name="td">
                    </div>        
                </div>
                <div class="db-field-add">
                	<div class="field-add">
						<label>Nhập số lượng :</label>
						<input type="number" min="1" name="soluong">
					</div>
					<div class="field-add">
						<label>Phần trăm giảm (%) :</label>
						<input type="number" min="1" name="discount">
					</div>
                </div>
				<div class="field-add">
					<button class="btn btn-success" type="submit">Thêm MGG</button>
				</div>
			</form>
			<div class="field-add" style="margin:0;">
				<button class="btn btn-danger quaylai">Quay Lại</button>
			</div>
		</div>
	</div>
	<div class="bg-fix hide-bg-fix">
		<div class="af-mng">
			<form action="{{ route('manager.cp',['type' => 'fix']) }}" method="POST" enctype="multipart/form-data" id="form_fix_gg">
				<div class="field-add">
					<label>Nhập tên mã :</label>
					<input type="text" name="name" id="fix_name_gg">
				</div>
				<div class="db-field-add">
                    <div class="field-add">
                        <label>Từ ngày :</label>
                        <input type="date" name="fd" id="fix_fd_gg">
                    </div>
                    <div class="field-add">
                        <label>Đến ngày :</label>
                        <input type="date" name="td" id="fix_td_gg">
                    </div>        
                </div>
                <div class="db-field-add">
					<div class="field-add">
						<label>Nhập số lượng :</label>
						<input type="text" name="soluong" id="soluong" disabled>
					</div>
					<div class="field-add">
						<label>Phần trăm giảm (%) :</label>
						<input type="text" name="discount" id="fix_pt_gg">
					</div>
				</div>
				<div class="field-add">
					<button class="btn btn-success" type="submit">Sửa MGG</button>
				</div>
			</form>
			<div class="field-add" style="margin:0;">
				<button class="btn btn-danger quaylai">Quay Lại</button>
			</div>
		</div>
	</div>
	<div class="bg-del hide-bg-del">
		<div class="del-mng">
			<div class="field-add">
				<h4 class="text-center">Bạn có chắc muốn xóa mã này ?</h4 class="text-center">
			</div>
			<div class="field-add">
				<a href="{{ route('manager.cp',['type' => 'del']) }}" class="btn btn-success" id="acp-del" type="submit">Xóa</a>
			</div>
			<button class="btn btn-danger quaylai" type="submit">Quay Lại</button>
		</div>
	</div>

@endif

@if(session('msg'))
	<div class="bg-err">
		<div class="error">
			<span>{{ session('msg') }}</span><hr>
			<button class="btn btn-danger quaylai">Quay Lại</button>
		</div>
	</div>
@endif