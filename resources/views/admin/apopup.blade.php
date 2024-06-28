@if ($mng == "sections" && $permission == 'Admin' || $mng == "sections" && $permission == 'Designer')
	<div class="bg-add hide-bg">
		<div class="af-mng">
			<h3 class="text-center">Thêm Bố Cục</h3>
			<form action="{{ route('manager.ss',['type' => 'add']) }}" method="POST" data-type="ss" enctype="multipart/form-data" class="admin-add">
				<div class="row">
					<div class="col-6">
						<div class="field-add">
							<label>Tên Section :</label>
							<input type="text" name="name">
						</div>
						<div class="db-field-add">
	                        <div class="field-add">
	                            <label>Phân Loại :</label>
	                            <select name="id_cata_1">
	                            	<option value="">Không Chọn</option>
	                            	@foreach ($cat1 as $value => $item)
	                            		<option value="{{$item['id']}}">{{$item['name']}}</option>
	                            	@endforeach
	                            	
	                            </select>
	                        </div>
	                        <div class="field-add">
	                            <label>Danh Mục :</label>
	                            <select name="id_cata_2">
	                            	<option value="">Không Chọn</option>
	                            	@foreach ($cat2 as $value => $item)
	                            		<option value="{{$item['id']}}">{{$item['name']}}</option>
	                            	@endforeach
	                            </select>
	                        </div>        
	                    </div>
	                    <div class="db-field-add">
	                        <div class="field-add">
	                            <label>Mục Tham Chiếu :</label>
	                            <select name="reference">
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
	                            <select name="orderby">
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
                            <input type="file" name="eb_img">
                        </div>  
                        <div class="field-add">
	                        <label>Vị Trí :</label>
	                        <input type="number" min="1" name="index">
	                    </div>    
					</div>
				</div>
				<div class="field-add">
					<button class="btn btn-success" type="submit">Thêm Section</button>
				</div>
			</form>
			<div class="field-add" style="margin:0;">
				<button class="btn btn-danger btn-crud getback">Quay Lại</button>
			</div>
		</div>
	</div>
	<div class="bg-fix hide-bg">
		<div class="af-mng">
			<h3 class="text-center">Sửa Bố Cục</h3>
			<form action="{{ route('manager.ss',['type' => 'fix']) }}" method="POST" data-type="ss" enctype="multipart/form-data" class="admin-fix">
				<input type="number" name="id" hidden id="f-id">
				<div class="row">
					<div class="col-6">
						<div class="field-add">
							<label>Tên Section :</label>
							<input type="text" name="name" id="f-fn">
						</div>
						<div class="db-field-add">
	                        <div class="field-add">
	                            <label>Phân Loại :</label>
	                            <select name="id_cata_1" id="f-c1">
	                            	<option value="">Không Chọn</option>
	                            	@foreach ($cat1 as $value => $item)
	                            		<option value="{{$item['id']}}">{{$item['name']}}</option>
	                            	@endforeach
	                            </select>
	                        </div>
	                        <div class="field-add">
	                            <label>Danh Mục :</label>
	                            <select name="id_cata_2" id="f-c2">
	                            	<option value="">Không Chọn</option>
	                            	@foreach ($cat2 as $value => $item)
	                            		<option value="{{$item['id']}}">{{$item['name']}}</option>
	                            	@endforeach
	                            </select>
	                        </div>        
	                    </div>
	                    <div class="db-field-add">
	                        <div class="field-add">
	                            <label>Mục Tham Chiếu :</label>
	                            <select name="reference" id="f-rf">
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
	                            <select name="orderby" id="f-or">
	                            	<option value="1">A-Z 0-9</option>
	                            	<option value="2">Z-A 9-0</option>
	                            	<option value="3">Ngẫu Nhiên</option>
	                            </select>
	                        </div>        
	                    </div>
					</div>
					<div class="col-6">
						<div class="field-add">
                            <label>Poster : (không chọn nếu sử dụng ảnh cũ)</label>
                            <input type="file" name="newposter">
                            <input type="text" name="oldposter" id="f-pt" hidden>
                        </div>
                        <div class="field-add">
                            <label>Ảnh Nền : (không chọn nếu sử dụng ảnh cũ)</label>
                            <input type="file" name="neweb_img">
                            <input type="text" name="oldeb_img" id="f-ep" hidden>
                        </div>  
                        <div class="field-add">
	                        <label>Vị Trí :</label>
	                        <input type="number" min="1" name="index" id="f-in">
	                    </div>    
					</div>
				</div>
				<div class="field-add">
					<button class="btn btn-success" type="submit">Sửa Section</button>
				</div>
			</form>
			<div class="field-add" style="margin:0;">
				<button class="btn btn-danger btn-crud getback">Quay Lại</button>
			</div>
		</div>
	</div>
	<div class="bg-del hide-bg">
		<div class="del-mng">
			<div class="field-add">
				<h4 class="text-center">Bạn có chắc muốn xóa Section ?</h4 class="text-center">
			</div>
			<div class="field-add">
				<button data-url="{{ route('manager.ss',['type' => 'del']) }}" data-type="ss" class="btn btn-success admin-del" id="acp-del">Xóa</button>
			</div>
			<button class="btn btn-danger btn-crud getback" type="submit">Quay Lại</button>
		</div>
	</div>

@elseif ($mng == "slidebns" && $permission == 'Admin' || $mng == "slidebns" && $permission == 'Designer')
	<div class="bg-add hide-bg">
		<div class="af-mng">
			<h3 class="text-center">Thêm Slide Cho Banner</h3>
			<form action="{{ route('manager.bn',['type' => 'add']) }}" method="POST" data-type="bn" enctype="multipart/form-data" class="admin-add">
				<div class="row">
					<div class="field-add">
						<label>Tiêu Đề :</label>
						<input type="text" name="tit">
					</div>
					<div class="field-add">
						<label>Đoạn Văn Bản :</label>
						<textarea name="ctn"></textarea>
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
				<button class="btn btn-danger btn-crud getback">Quay Lại</button>
			</div>
		</div>
	</div>
	<div class="bg-fix hide-bg">
		<div class="af-mng">
			<h3 class="text-center">Sửa Slide</h3>
			<form action="{{ route('manager.bn',['type' => 'fix']) }}" method="POST" data-type="bn" enctype="multipart/form-data" class="admin-fix">
				<input type="number" name="id" hidden id="f-id">
				<div class="row">
					<div class="field-add">
						<label>Tiêu Đề :</label>
						<input type="text" name="tit" id="f-tt">
					</div>
					<div class="field-add">
						<label>Đoạn Văn Bản :</label>
						<textarea name="ctn" id="f-ct"></textarea>
					</div>
					<div class="field-add">
	                    <label>Banner : (Không chọn nếu sử dụng ảnh cũ)</label>
	                    <input type="file" name="newimg">
	                    <input type="text" name="oldimg" hidden id="f-im">
	                </div>
				</div>
				<div class="field-add">
					<button class="btn btn-success" type="submit">Sửa Banner</button>
				</div>
			</form>
			<div class="field-add" style="margin:0;">
				<button class="btn btn-danger btn-crud getback">Quay Lại</button>
			</div>
		</div>
	</div>
	<div class="bg-del hide-bg">
		<div class="del-mng">
			<div class="field-add">
				<h4 class="text-center">Bạn có chắc muốn xóa Banner ?</h4 class="text-center">
			</div>
			<div class="field-add">
				<button data-url="{{ route('manager.bn',['type' => 'del']) }}" data-type="bn" class="btn btn-success admin-del" id="acp-del">Xóa</button>
			</div>
			<button class="btn btn-danger btn-crud getback" type="submit">Quay Lại</button>
		</div>
	</div>

@elseif ($mng == "products" && $permission == 'Admin' || $mng == "products" && $permission == 'Seller')
	<div class="bg-add hide-bg">
		<div class="af-mng">
			<h3 class="text-center">Thêm Sản Phẩm</h3>
			<form action="{{ route('manager.pd',['type' => 'add']) }}" method="POST" data-type="pd" enctype="multipart/form-data" class="admin-add">
				<div class="row">
					<div class="col-6">
						<div class="field-add">
							<label>Tên Sản Phẩm :</label>
							<input type="text" name="name">
						</div>
						<div class="db-field-add">
							<div class="field-add">
								<label>Danh Mục :</label>
								<select name="id_cata_2" id="">
									<option value=""></option>
									@foreach ($cat2 as $value => $item)
	                            		<option value="{{$item['id']}}">{{$item['name']}}</option>
	                            	@endforeach
								</select>
							</div>
							<div class="field-add">
								<label>Thương Hiệu :</label>
								<select name="id_brand" id="">
									<option value=""></option>
									@foreach ($brands as $value => $item)
	                            		<option value="{{$item['id']}}">{{$item['name']}}</option>
	                            	@endforeach
								</select>
							</div>
						</div>
						<div class="field-add">
							<label>Phân Loại :</label>
							<select name="id_cata_1" id="">
								<option value=""></option>
								@foreach ($cat1 as $value => $item)
                            		<option value="{{$item['id']}}">{{$item['name']}}</option>
                            	@endforeach
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
								<input type="date" name="f_date">
							</div>
							<div class="field-add">
								<label>Sale đến ngày (nếu có) :</label>
								<input type="date" name="t_date">
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
				<button class="btn btn-danger btn-crud getback">Quay Lại</button>
			</div>
		</div>
	</div>
	<div class="bg-fix hide-bg">
		<div class="af-mng">
			<h3 class="text-center">Sửa Sản Phẩm</h3>
			<form action="{{ route('manager.pd',['type' => 'fix']) }}" method="POST" data-type="pd" enctype="multipart/form-data" class="admin-fix">
				<input type="number" name="id" hidden id="f-id">
				<div class="row">
					<div class="col-6">
						<div class="field-add">
							<label>Tên Sản Phẩm :</label>
							<input type="text" name="name" id="f-fn">
						</div>
						<div class="db-field-add">
							<div class="field-add">
								<label>Danh Mục :</label>
								<select name="id_cata_2" id="f-c2">
									<option value=""></option>
									@foreach ($cat2 as $value => $item)
	                            		<option value="{{$item['id']}}">{{$item['name']}}</option>
	                            	@endforeach
								</select>
							</div>
							<div class="field-add">
								<label>Thương Hiệu :</label>
								<select name="id_brand" id="f-br">
									<option value=""></option>
									@foreach ($brands as $value => $item)
	                            		<option value="{{$item['id']}}">{{$item['name']}}</option>
	                            	@endforeach
								</select>
							</div>
						</div>
						<div class="field-add">
							<label>Phân Loại :</label>
							<select name="id_cata_1" id="f-c1">
								<option value="" ></option>
								@foreach ($cat1 as $value => $item)
                            		<option value="{{$item['id']}}">{{$item['name']}}</option>
                            	@endforeach
							</select>
						</div>
					</div>
					<div class="col-6">
						<div class="db-field-add">
							<div class="field-add">
								<label>Giá Sản Phẩm :</label>
								<input type="number" name="price" id="f-pr">
							</div>
							<div class="field-add">
								<label>Giá Sale (nếu có) :</label>
								<input type="number" name="sale" id="f-sl">
							</div>
						</div>
						<div class="db-field-add">
							<div class="field-add">
								<label>Sale từ ngày (nếu có) :</label>
								<input type="date" name="f_date" id="f-sf">
							</div>
							<div class="field-add">
								<label>Sale đến ngày (nếu có) :</label>
								<input type="date" name="t_date" id="f-st">
							</div>
						</div>
						<div class="field-add">
							<label>Mô tả :</label>
							<input type="text" id="f-if" name="info">
						</div>
					</div>
					<div class="col-12">
						<div class="field-add">
							<label>Thông tin chi tiết :</label>
							<textarea name="detail" id="ttct-sp"></textarea>
						</div>
						<div class="field-add">
							<label style="width:auto; margin: 0 30px 0 0;">Hình ảnh ( không chọn nếu sử dụng ảnh cũ ) :</label>
							<input type="file" name="newimg">
							<input type="text" name="oldimg" id="f-im" hidden>
						</div>
					</div>
					<div class="col-12">
						<button class="btn btn-success" type="submit">Cập Nhật Sản Phẩm</button>
					</div>
				</div>
			</form><hr>
			<div class="field-add" style="margin:0;">
				<button class="btn btn-danger btn-crud getback">Quay Lại</button>
			</div>
		</div>
	</div>
	<div class="bg-del hide-bg">
		<div class="del-mng">
			<div class="field-add">
				<h4 class="text-center">Bạn có chắc muốn xóa sản phẩm ?</h4 class="text-center">
			</div>
			<div class="field-add">
				<button data-url="{{ route('manager.pd',['type' => 'del']) }}" data-type="pd" class="btn btn-success admin-del" id="acp-del">Xóa</button>
			</div>
			<button class="btn btn-danger btn-crud getback" type="submit">Quay Lại</button>
		</div>
	</div>
	<div class="popup-small hide-popup">
		<i class="fa-solid fa-eye-slash"></i>
		<span>Đã Ẩn Sản Phẩm</span>
	</div>

@elseif ($mng == "catalogs" && $permission == 'Admin' || $mng == "catalogs" && $permission == 'Seller')
	<div class="bg-add hide-bg">
		<div class="af-mng">
			<h3 class="text-center">Thêm Danh Mục</h3>
			<div class="row">
				<div class="col-6">
					<form action="{{ route('manager.c2',['type' => 'add']) }}" method="POST" data-type="c2" enctype="multipart/form-data" class="admin-add">
						<h3 class="text-center">Thêm Danh Mục</h3>
						<div class="db-field-add">
							<div class="field-add">
								<label>Tên Danh Mục :</label>
								<input type="text" name="name">
							</div>
							<div class="field-add">
								<label>Mã Phân Loại</label>
								<select name="type" id="pl">
									@foreach ($list1 as $value => $item)
	                            		<option value="{{$item['id']}}">Mã: {{$item->id}} | {{$item->name}}</option>
	                            	@endforeach
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
					<form action="{{ route('manager.c1',['type' => 'add']) }}" method="POST" data-type="c1" enctype="multipart/form-data" class="admin-add">
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
				<button class="btn btn-danger btn-crud getback">Quay Lại</button>
			</div>
		</div>
	</div>
	<div class="bg-fix hide-bg">
		<div class="af-mng">
			<h3 class="text-center">Sửa Danh Mục</h3>
			<div class="row">
				<div class="col-6">
					<form action="{{ route('manager.c2',['type' => 'fix']) }}" method="POST" data-type="c2" enctype="multipart/form-data" class="admin-fix">
						<input type="number" name="id" hidden id="f-id2">
						<h3 class="text-center">Cập Nhật Danh Mục</h3>
						<div class="db-field-add">
							<div class="field-add">
								<label>Tên Danh Mục :</label>
								<input type="text" name="name" id="f-fn2">
							</div>
							<div class="field-add">
								<label>Mã Phân Loại</label>
								<select name="type" id="f-c1">
									@foreach ($list1 as $value => $item)
	                            		<option value="{{$item['id']}}">Mã: {{$item->id}} | {{$item->name}}</option>
	                            	@endforeach
								</select>
							</div>
						</div>
						<div class="field-add">
							<label style="width:auto; margin: 0 30px 0 0;">IMG (nếu có) :</label>
							<input type="file" name="newimg">
							<input type="text" name="oldimg" id="f-im2" hidden>
						</div>
						<div class="field-add">
							<button class="btn btn-success" type="submit">Cập Nhật Danh Mục</button>
						</div>
					</form>
				</div>
				<div class="col-6">
					<form action="{{ route('manager.c1',['type' => 'fix']) }}" method="POST" data-type="c1" enctype="multipart/form-data" class="admin-fix">
						<input type="number" name="id" hidden id="f-id1">
						<h3 class="text-center">Cập Nhật Phân Loại</h3>
						<div class="field-add">
							<label>Tên Phân Loại :</label>
							<input type="text" name="name" id="f-fn1">
						</div>
						<div class="field-add">
							<button class="btn btn-success" type="submit">Cập Nhật Phân Loại</button>
						</div>
					</form>
				</div>
			</div>
			<div class="field-add" style="margin:0;">
				<button class="btn btn-danger btn-crud getback">Quay Lại</button>
			</div>
		</div>
	</div>
	<div class="bg-del hide-bg">
		<div class="del-mng">
			<div class="field-add">
				<h4 class="text-center">Bạn có chắc muốn xóa danh mục ?</h4 class="text-center">
			</div>
			<div class="field-add">
				<button data-url="" data-type="" class="btn btn-success admin-del" id="acp-del">Xóa</button>
			</div>
			<button class="btn btn-danger btn-crud getback" type="submit">Quay Lại</button>
		</div>
	</div>

@elseif ($mng == "usersmng" && $permission == 'Admin')
	<div class="bg-add hide-bg">
		<div class="af-mng">
			<h3 class="text-center">Thêm User</h3>
			<form action="{{ route('manager.us',['type' => 'add']) }}" method="POST" data-type="us" enctype="multipart/form-data" class="admin-add">
				<div class="row">
					<div class="col-6">
						<div class="field-add">
							<label>Tên Tài Khoản :</label>
							<input type="text" name="account">
						</div>
						<div class="field-add">
                            <label>Họ và Tên :</label>
                            <input type="text" name="name">
                        </div>
                        <div class="db-field-add">
                        	<div class="field-add">
								<label style="width:auto; margin: 0 30px 0 0;">Role :</label>
								<select name="role" id="">
									<option value="0">Client</option>
									<option value="1">Admin</option>
								</select>
							</div>
							<div class="field-add">
								<label style="width:auto; margin: 0 30px 0 0;">Loại :</label>
								<select name="permission" id="">
									<option value="">Không Chọn</option>
									<option value="Admin">Admin</option>
									<option value="Seller">Seller</option>
									<option value="Designer">Designer</option>
								</select>
							</div>
                        </div>
					</div>
					<div class="col-6">
						<div class="field-add">
                            <label>Email :</label>
                            <input type="text" name="email">

                        </div>
                        <div class="field-add">
                            <label>Số điện thoại :</label>
                            <input type="number" name="number">
                        </div>  
                        <div class="field-add">
	                        <label>Địa chỉ :</label>
	                        <input type="text" name="address">
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
				<button class="btn btn-danger btn-crud getback">Quay Lại</button>
			</div>
		</div>
	</div>
	<div class="bg-fix hide-bg">
		<div class="af-mng">
			<h3 class="text-center">Sửa User</h3>
			<form action="{{ route('manager.us',['type' => 'fix']) }}" method="POST" data-type="us" enctype="multipart/form-data" class="admin-fix">
				<input type="number" name="id" hidden id="f-id">
				<div class="row">
					<div class="col-6">
						<div class="field-add">
							<label>Tên Tài Khoản :</label>
							<input type="text" name="account" id="f-ac">
						</div>
						<div class="field-add">
                            <label>Họ và Tên:</label>
                            <input type="text" name="name" id="f-fn">
                        </div>
                        <div class="db-field-add">
                        	<div class="field-add">
								<label style="width:auto; margin: 0 30px 0 0;">Role :</label>
								<select name="role" id="f-rl">
									<option value="0">Client</option>
									<option value="1">Admin</option>
								</select>
							</div>
							<div class="field-add">
								<label style="width:auto; margin: 0 30px 0 0;">Loại :</label>
								<select name="permission" id="f-pm">
									<option value="">Không Chọn</option>
									<option value="Admin">Admin</option>
									<option value="Seller">Seller</option>
									<option value="Designer">Designer</option>
								</select>
							</div>
                        </div>
					</div>
					<div class="col-6">
						<div class="field-add">
                            <label>Email :</label>
                            <input type="text" name="email" id="f-em">
                        </div>
                        <div class="field-add">
                            <label>Số điện thoại :</label>
                            <input type="number" name="number" id="f-nb">
                        </div>  
	                    <div class="field-add">
	                        <label>Địa chỉ :</label>
	                        <input type="text" name="address" id="f-ad">
	                    </div>
					</div>
				</div>
				<div class="field-add">
					<label style="width:auto; margin: 0 30px 0 0;">Mật Khẩu: (Không nhập nếu không đổi)</label>
					<input type="password" name="newpass" value="">
					<input type="password" name="oldpass" hidden id="f-pw">
				</div>
						
				<div class="field-add">
					<button class="btn btn-success" type="submit">Cập Nhật</button>
				</div>
			</form>
			<div class="field-add" style="margin:0;">
				<button class="btn btn-danger btn-crud getback">Quay Lại</button>
			</div>
		</div>
	</div>
	<div class="bg-del hide-bg">
		<div class="del-mng">
			<div class="field-add">
				<h4 class="text-center">Bạn có chắc muốn xóa người dùng ?</h4 class="text-center">
			</div>
			<div class="field-add">
				<button data-url="{{ route('manager.us',['type' => 'del']) }}" data-type="us" class="btn btn-success admin-del" id="acp-del">Xóa</button>
			</div>
			<button class="btn btn-danger btn-crud getback">Quay Lại</button>
		</div>
	</div>
	<div class="popup-small hide-popup">
		<i class="fa-solid fa-ban"></i>
		<span>Đã Khóa Tài Khoản</span>
	</div>

@elseif ($mng == "comments" && $permission == 'Admin')
	<div class="bg-del hide-bg">
		<div class="del-mng">
			<div class="field-add">
				<h4 class="text-center">Bạn có chắc muốn xóa bình luận này ?</h4 class="text-center">
			</div>
			<div class="field-add">
				<button data-url="{{ route('manager.cm',['type' => 'del']) }}" data-type="cm" class="btn btn-success admin-del" id="acp-del">Xóa</button>
			</div>
			<button class="btn btn-danger btn-crud getback" type="submit">Quay Lại</button>
		</div>
	</div>
	<div class="bg-inf hide-bg">
		<div class="dsbl">
			<table style="width: 100%; margin: 15px 0 30px;" class="list-cm">
				<thead>
					<tr>
						<th style="width: auto;">Nội dung</th>
						<th style="width: 70px;">ID User</th>
						<th style="width: 120px;">Ngày</th>
						<th style="width: 70px;">Xóa</th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
			<button class="btn btn-danger btn-crud getback">Quay Lại</button>
		</div>
	</div>

@elseif ($mng == "offers" && $permission == 'Admin' || $mng == "offers" && $permission == 'Seller')
	<div class="bg-add hide-bg">
		<div class="af-mng">
			<h3 class="text-center">Thêm Mã Khuyến Mãi</h3>
			<form action="{{ route('manager.cp',['type' => 'add']) }}" method="POST" data-type="cp" enctype="multipart/form-data" class="admin-add">
				<div class="field-add">
					<label>Nhập tên mã :</label>
					<input type="text" name="name">
				</div>
				<div class="db-field-add">
                    <div class="field-add">
                        <label>Từ ngày :</label>
                        <input type="date" name="f_date">
                    </div>
                    <div class="field-add">
                        <label>Đến ngày :</label>
                        <input type="date" name="t_date">
                    </div>        
                </div>
                <div class="db-field-add">
                	<div class="field-add">
						<label>Nhập số lượng :</label>
						<input type="number" min="1" name="amount">
					</div>
					<div class="field-add">
						<label>Giảm :</label>
						<input type="text" min="1" name="discount">
					</div>
                </div>
                <div class="field-add">
					<label>Loại :</label>
					<select name="type" id="">
						<option value="percent">Phần Trăm</option>
						<option value="number">Số cụ thể</option>
					</select>
				</div>
				<div class="field-add">
					<button class="btn btn-success" type="submit">Thêm MGG</button>
				</div>
			</form>
			<div class="field-add" style="margin:0;">
				<button class="btn btn-danger btn-crud getback">Quay Lại</button>
			</div>
		</div>
	</div>
	<div class="bg-fix hide-bg">
		<div class="af-mng">
			<h3 class="text-center">Sửa Mã Khuyến Mãi</h3>
			<form action="{{ route('manager.cp',['type' => 'fix']) }}" method="POST" data-type="cp" enctype="multipart/form-data" class="admin-fix">
				<input type="number" name="id" hidden id="f-id">
				<div class="field-add">
					<label>Nhập tên mã :</label>
					<input type="text" name="name" id="f-fn">
				</div>
				<div class="db-field-add">
                    <div class="field-add">
                        <label>Từ ngày :</label>
                        <input type="date" name="f_date" id="f-fd">
                    </div>
                    <div class="field-add">
                        <label>Đến ngày :</label>
                        <input type="date" name="t_date" id="f-td">
                    </div>        
                </div>
                <div class="db-field-add">
					<div class="field-add">
						<label>Nhập số lượng :</label>
						<input type="text" name="amount" id="f-mx" disabled>
					</div>
					<div class="field-add">
						<label>Giảm :</label>
						<input type="text" name="discount" id="f-dc">
					</div>
				</div>
				<div class="field-add">
					<label>Loại :</label>
					<select name="type" id="f-tp">
						<option value="percent">Phần Trăm</option>
						<option value="number">Số cụ thể</option>
					</select>
				</div>
				<div class="field-add">
					<button class="btn btn-success" type="submit">Sửa MGG</button>
				</div>
			</form>
			<div class="field-add" style="margin:0;">
				<button class="btn btn-danger btn-crud getback">Quay Lại</button>
			</div>
		</div>
	</div>
	<div class="bg-del hide-bg">
		<div class="del-mng">
			<div class="field-add">
				<h4 class="text-center">Bạn có chắc muốn xóa mã này ?</h4 class="text-center">
			</div>
			<div class="field-add">
				<button data-url="{{ route('manager.cp',['type' => 'del']) }}" data-type="cp" class="btn btn-success admin-del" id="acp-del">Xóa</button>
			</div>
			<button class="btn btn-danger btn-crud getback" type="submit">Quay Lại</button>
		</div>
	</div>

@elseif ($mng == "invoices" && $permission == 'Admin' || $mng == "invoices" && $permission == 'Seller')
	<div class="popup-small hide-popup">
		<span>Cập Nhật Đơn Hàng Thành Công</span>
	</div>

@endif

<div class="bg-err hide-bg">
	<div class="error">
		<span>{{ session('msg') }}</span>
	</div>
</div>