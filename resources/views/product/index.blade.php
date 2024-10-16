<?php
namespace App\Controllers\app\product;
use App\Controllers\BaseController;

use App\Models\color\ColorModel;
use App\Models\brand\BrandModel;
use App\Models\seller\SellerModel;
use App\Models\product\ProductModel;
use App\Models\category\CategoryModel;
use App\Models\attribute\AttributeModel;
use App\Models\product\ProductDeferModel;
use App\Models\rental_type\RentalTypeModel;
use App\Models\manufacturer\ManufacturerModel;
use App\Models\product_rental\ProductRentalModel;
use App\Models\product_variant\ProductVariantModel;
use App\Models\attribute_values\AttributeValuesModel;

class Product extends BaseController {

    public function __construct() {
        $db = db_connect();
        $this->session                  = \Config\Services::session();

        $this->seller                   = new SellerModel($db);
        $this->color                    = new ColorModel($db);
        $this->brand                    = new BrandModel($db);
        $this->product                  = new ProductModel($db);
        $this->attribute                = new AttributeModel($db);
        $this->category                 = new CategoryModel($db);
        $this->productDefer             = new ProductDeferModel($db);
        $this->rentalType               = new RentalTypeModel($db);
        $this->manufacturer             = new ManufacturerModel($db);
        $this->productRental            = new ProductRentalModel($db);
        $this->productVariant           = new ProductVariantModel($db);
        $this->attributeValues          = new AttributeValuesModel($db);

        $this->login_role               = $this->session->get('login_role');
        $this->login_id                 = $this->session->get('login_id');
        $this->ip_address               = $_SERVER['REMOTE_ADDR'];
        $this->datetime                 = date("Y-m-d H:i:s");
    }

    public function index() {
        $this->list();
    }

    public function list() {
        $data = [];
        $data['content_title']              = 'Manage Products';
        $data['main_content']               = 'app/product/list';
        $data['form_name']                  = 'form-add-product';
        echo view("app/innerpages/template", $data);
    }

    public function add() {
        $data = [];
        $data['content_title']              = 'New Product';
        $data['main_content']               = 'app/product/add';
        $data['category_dropdown']          = $this->category_dropdown();
        $data['color_dropdown']             = $this->color_dropdown();
        $data['brand_dropdown']             = $this->brand_dropdown();
        $data['manufacturer_dropdown']      = $this->manufacturer_dropdown();
        $data['rental_type_dropdown']        = $this->rental_type_dropdown();
        $data['attribute_dropdown']         = $this->attribute_dropdown();
        $data['form_name']                  = 'form-add-product';
        echo view("app/innerpages/template", $data);
    }

    public function edit() {
        $id     = $this->request->getGet('id');
        $where  = [];
        $where ['id']    = $id;
        if($this->login_role != "admin") 
            $where ['seller_id']    = $this->login_id;
        $result = $this->product->getEntry($where);
        if($result) {
            $data   = [];
            $data['content_title']              = 'Update Product';
            $data['main_content']               = 'app/product/edit';
            $data['category_dropdown']          = $this->category_dropdown();
            $data['color_dropdown']             = $this->color_dropdown();
            $data['brand_dropdown']             = $this->brand_dropdown();
            $data['manufacturer_dropdown']      = $this->manufacturer_dropdown();
            $data['rental_type_dropdown']        = $this->rental_type_dropdown();
            $data['attribute_dropdown']         = $this->attribute_dropdown();
            $data['result']                     = $result;
            $data['seller_result']              = $this->seller->getEntry(['id' => $result->seller_id]);
            $data['product_variant_result']     = $this->productVariant->getEntryList(['product_id' => $result->id]);
            $data['product_rental_result']      = $this->productRental->getEntryList(['product_id' => $result->id]);
            $data['choice_option_result']       = $this->getChoiceOptionsList($result);
            $data['form_name']                  = 'form-update-product';
            echo view("app/innerpages/template", $data); 
        } else {
            return redirect()->to(base_url('app/product'));
        }
    }

    public function create() {
        $seller_id                  = $this->request->getPost('seller_id');
        $name                       = $this->request->getPost('name');
        $category_id                = $this->request->getPost('category_id');
        $sub_category_id            = $this->request->getPost('sub_category_id');
        $short_description          = $this->request->getPost('short_description');
        $tags                       = $this->request->getPost('tags');
        $brand_id                   = $this->request->getPost('brand_id');
        $manufacturer_id            = $this->request->getPost('manufacturer_id');
        $total_allow_qty            = $this->request->getPost('total_allow_qty');
        $min_order_qty              = $this->request->getPost('min_order_qty');
        $tax_rate                   = $this->request->getPost('tax_rate');
        $delivery_type              = $this->request->getPost('delivery_type');
        $is_returnable              = $this->request->getPost('is_returnable');
        $return_days                = $this->request->getPost('return_days');
        $is_cancelable              = $this->request->getPost('is_cancelable');
        $description                = $this->request->getPost('description');
        $extra_description          = $this->request->getPost('extra_description');
        $expected_delivery_duration = $this->request->getPost('expected_delivery_duration');
        $status                     = $this->request->getPost('status');
        $image_url                  = $this->request->getPost('image_url');
        $gallery_image              = $this->request->getPost('gallery_image_url');
        $color                      = $this->request->getPost('color');
        $price                      = $this->request->getPost('price');
        $old_price                  = $this->request->getPost('old_price');
        $rental_type_id             = $this->request->getPost('rental_type_id');
        $tax_group                  = $this->request->getPost('tax_group');
        $tax                        = $this->request->getPost('tax');

        $colors_active              = $this->request->getPost('colors_active');
        $choice_attributes          = $this->request->getPost('choice_attributes');
        $choice_no                  = $this->request->getPost('choice_no');
        $variant_product            = $this->request->getPost('variant_product');

        $slug                       = url_title($name, '-', true);
        if($seller_id) {
            $where = [
                'seller_id' => $seller_id,
                'name'      => $name,
            ];
            $result = $this->product->getEntry($where);
            if($result) {
                $json = [
                    'message'   => "The entered product is already exists.",
                    'status'    => false,
                ];
            } else {
                $rental_type_result  = $this->rentalType->getEntry(['id' => $rental_type_id]);
                // $category_name      = $this->category->getEntry(['id' => $category_id])->slug;
                $brand_result       = $this->brand->getEntry(['id' => $brand_id]);
                $brand_name         = ($brand_result) ? $brand_result->name : '';
                $made_in_result     = $this->manufacturer->getEntry(['id' => $manufacturer_id]);
                $made_in_name       = ($made_in_result) ? $made_in_result->name : '';
                $tags               = ($tags) ? json_encode($tags) : '';
                $data = [
                    'seller_id'                     => $seller_id,
                    'name'                          => $name,
                    'image_url'                     => $image_url,
                    'gallery_image_url'             => ($gallery_image) ? json_encode($gallery_image) : '',
                    'category_id'                   => json_encode($category_id),
                    // 'category_name'                 => $category_name,
                    // 'sub_category_id'               => $sub_category_id,
                    // 'sub_category_name'             => $sub_category_name,
                    'short_description'             => $short_description,
                    'tags'                          => $tags,
                    'brand_id'                      => $brand_id,
                    'brand_name'                    => $brand_name,
                    'manufacturer_id'               => $manufacturer_id,
                    'manufacturer_name'             => $made_in_name,
                    'tax_group'                     => $tax_group,
                    'tax'                           => $tax,
                    'price'                         => $price,
                    'old_price'                     => $old_price,
                    'rental_type_id'                => $rental_type_result->id,
                    'rental_type_name'              => $rental_type_result->name,
                    'rental_type_days'              => $rental_type_result->days,
                    'color'                         => ($color) ? json_encode($color) : '',
                    // 'tax_rate'                      => $tax_rate,
                    // 'delivery_type'                 => $delivery_type,
                    'total_allow_qty'               => $total_allow_qty,
                    'min_order_qty'                 => $min_order_qty,
                    'is_returnable'                 => $is_returnable,
                    'return_days'                   => $return_days,
                    'is_cancelable'                 => $is_cancelable,
                    'expected_delivery_duration'    => $expected_delivery_duration,
                    'description'                   => $description,
                    'extra_description'             => $extra_description,
                    'ip_address'                    => $this->ip_address,
                    'created_at'                    => $this->datetime,
                    'status'                        => $status,
                ];
                $product_id = $this->product->addEntry($data);
                if($product_id) {
                    $slug   = url_title($name, '-', true);
                    $data = [
                        'slug'  => $slug . '-' . $product_id,
                    ];
                    $this->product->updateEntry(['id' => $product_id], $data);
                    // Product Variation
                    $options        = [];
                    $choice_options = [];
                    if ($colors_active && $color && count($color) > 0) {
                        $colors_active = 1;
                        array_push($options, $color);
                    } else {
                        $colors_active = 0;
                    }

                    if ($choice_no) {
                        foreach ($choice_no as $key => $no) {
                            $_name = 'choice_options_' . $no;
                            $items = [];
                            if ($this->request->getPost($_name)) {
                                $data = array();
                                foreach ($this->request->getPost($_name) as $key => $item) {
                                    array_push($data, $item);
                                }
                                array_push($options, $data);
                                $items = $data;
                            }
                            $choice_options []      = [
                                'attribute_id'  => $no,
                                'values'        => $items,
                            ];
                        }
                        $data = [
                            'choice_options'   => json_encode($choice_options),
                        ];
                        $this->product->updateEntry(['id' => $product_id], $data);
                    }

                    $combinations = generateCombination($options);
                    if($variant_product) {
                        $data = [
                            'variant_product'   => $variant_product,
                        ];
                        $this->product->updateEntry(['id' => $product_id], $data);

                        $variant_name       = $this->request->getPost('variant_name');
                        $variant_price      = $this->request->getPost('variant_price');
                        $variant_sku        = $this->request->getPost('variant_sku');
                        $variant_qty        = $this->request->getPost('variant_qty');
                        $variant_image_url  = $this->request->getPost('variant_image_url');
                        foreach ($variant_name as $key => $value) {
                            $data = [
                                'product_id'    => $product_id,
                                'variant'       => $variant_name[$key],
                                'rate'          => $variant_price[$key],
                                'sku'           => $variant_sku[$key],
                                'qty'           => $variant_qty[$key],
                                'image_url'     => $variant_image_url[$key],
                                'ip_address'    => $this->ip_address,
                                'created_at'    => $this->datetime,
                                'status'        => $status,
                            ];
                            $this->productVariant->addEntry($data);
                        }
                    }


                    // Product Rental
                    $rental_id          = $this->request->getPost('product_rental_id');
                    $plan_name          = $this->request->getPost('plan_name');
                    $plan_duration      = $this->request->getPost('plan_duration');
                    foreach ($plan_name as $key => $value) {
                        $data = [
                            'product_id'    => $product_id,
                            'name'          => $plan_name[$key],
                            'duration'    => $plan_duration[$key],
                            'ip_address'    => $this->ip_address,
                            'created_at'    => $this->datetime,
                            'status'        => $status,
                        ];
                        $this->productRental->addEntry($data);
                    }
                    $json = [
                        'message'   => "Product has been created successfully.",
                        'status'    => true,
                        'url'       => base_url('app/product/edit?id=' . $product_id),
                    ];
                } else {
                    $json = [
                        'message'   => "Something went wrong. Please try again.",
                        'status'    => false,
                    ];
                }
            }
        } else {
            $json = [
                'message'   => "Please select a seller from seller list.",
                'status'    => false,
            ];
        }
        echo json_encode($json);
    }

    public function update() {
        $product_id                 = $this->request->getPost('id');
        $seller_id                  = $this->request->getPost('seller_id');
        $name                       = $this->request->getPost('name');
        $category_id                = $this->request->getPost('category_id');
        $sub_category_id            = $this->request->getPost('sub_category_id');
        $short_description          = $this->request->getPost('short_description');
        $tags                       = $this->request->getPost('tags');
        $brand_id                   = $this->request->getPost('brand_id');
        $manufacturer_id            = $this->request->getPost('manufacturer_id');
        $total_allow_qty            = $this->request->getPost('total_allow_qty');
        $min_order_qty              = $this->request->getPost('min_order_qty');
        $tax_rate                   = $this->request->getPost('tax_rate');
        $delivery_type              = $this->request->getPost('delivery_type');
        $is_returnable              = $this->request->getPost('is_returnable');
        $return_days                = $this->request->getPost('return_days');
        $is_cancelable              = $this->request->getPost('is_cancelable');
        $description                = $this->request->getPost('description');
        $extra_description          = $this->request->getPost('extra_description');
        $expected_delivery_duration = $this->request->getPost('expected_delivery_duration');
        $status                     = $this->request->getPost('status');
        $image_url                  = $this->request->getPost('image_url');
        $gallery_image              = $this->request->getPost('gallery_image_url');
        $color                      = $this->request->getPost('color');
        $price                      = $this->request->getPost('price');
        $old_price                  = $this->request->getPost('old_price');
        $rental_type_id             = $this->request->getPost('rental_type_id');
        $tax_group                  = $this->request->getPost('tax_group');
        $tax                        = $this->request->getPost('tax');

        $colors_active              = $this->request->getPost('colors_active');
        $choice_attributes          = $this->request->getPost('choice_attributes');
        $choice_no                  = $this->request->getPost('choice_no');
        $variant_product            = $this->request->getPost('variant_product');

        $slug                       = url_title($name, '-', true);
        if($seller_id) {
            $where = [
                'id !='     => $product_id,
                'seller_id' => $seller_id,
                'name'      => $name,
            ];
            $result = $this->product->getEntry($where);
            if($result) {
                $json = [
                    'message'   => "The entered product is already exists.",
                    'status'    => false,
                ];
            } else {
                $rental_type_result  = $this->rentalType->getEntry(['id' => $rental_type_id]);
                // $category_name      = $this->category->getEntry(['id' => $category_id])->slug;
                $brand_result       = $this->brand->getEntry(['id' => $brand_id]);
                $brand_name         = ($brand_result) ? $brand_result->name : '';
                $made_in_result     = $this->manufacturer->getEntry(['id' => $manufacturer_id]);
                $made_in_name       = ($made_in_result) ? $made_in_result->name : '';
                $tags               = ($tags) ? json_encode($tags) : '';
                $data = [
                    'seller_id'                     => $seller_id,
                    'name'                          => $name,
                    'image_url'                     => $image_url,
                    'gallery_image_url'             => ($gallery_image) ? json_encode($gallery_image) : '',
                    'category_id'                   => json_encode($category_id),
                    'short_description'             => $short_description,
                    'tags'                          => $tags,
                    'brand_id'                      => $brand_id,
                    'brand_name'                    => $brand_name,
                    'manufacturer_id'               => $manufacturer_id,
                    'manufacturer_name'             => $made_in_name,
                    'tax_group'                     => $tax_group,
                    'tax'                           => $tax,
                    'price'                         => $price,
                    'old_price'                     => $old_price,
                    'rental_type_id'                => $rental_type_result->id,
                    'rental_type_name'              => $rental_type_result->name,
                    'rental_type_days'              => $rental_type_result->days,
                    'color'                         => ($color) ? json_encode($color) : '',
                    'attributes'                    => json_encode($choice_attributes),
                    // 'tax_rate'                      => $tax_rate,
                    // 'delivery_type'                 => $delivery_type,
                    'total_allow_qty'               => $total_allow_qty,
                    'min_order_qty'                 => $min_order_qty,
                    'return_days'                   => $return_days,
                    'is_cancelable'                 => $is_cancelable,
                    'expected_delivery_duration'    => $expected_delivery_duration,
                    'description'                   => $description,
                    'extra_description'             => $extra_description,
                    'ip_address'                    => $this->ip_address,
                    'status'                        => $status,
                ];
                $result = $this->product->updateEntry(['id' => $product_id], $data);
                if($result) {
                    $slug   = url_title($name, '-', true);
                    $data = [
                        'slug'  => $slug . '-' . $product_id,
                    ];
                    $this->product->updateEntry(['id' => $product_id], $data);

                    // Product Variation
                    $options        = [];
                    $choice_options = [];
                    if ($colors_active && $color && count($color) > 0) {
                        $colors_active = 1;
                        array_push($options, $color);
                    } else {
                        $colors_active = 0;
                    }

                    if ($choice_no) {
                        foreach ($choice_no as $key => $no) {
                            $_name = 'choice_options_' . $no;
                            $items = [];
                            if ($this->request->getPost($_name)) {
                                $data = array();
                                foreach ($this->request->getPost($_name) as $key => $item) {
                                    array_push($data, $item);
                                }
                                array_push($options, $data);
                                $items = $data;
                            }
                            $choice_options []      = [
                                'attribute_id'  => $no,
                                'values'        => $items,
                            ];
                        }
                        $data = [
                            'choice_options'   => json_encode($choice_options),
                        ];
                        $this->product->updateEntry(['id' => $product_id], $data);
                    }

                    $combinations = generateCombination($options);
                    if($variant_product) {
                        $data = [
                            'variant_product'   => $variant_product,
                        ];
                        $this->product->updateEntry(['id' => $product_id], $data);

                        $variant_id         = $this->request->getPost('variant_id');
                        $variant_name       = $this->request->getPost('variant_name');
                        $variant_price      = $this->request->getPost('variant_price');
                        $variant_sku        = $this->request->getPost('variant_sku');
                        $variant_qty        = $this->request->getPost('variant_qty');
                        $variant_image_url  = $this->request->getPost('variant_image_url');
                        foreach ($variant_name as $key => $value) {
                            if(isset($variant_id[$key]) && $variant_id[$key]) {
                                $data = [
                                    'product_id'    => $product_id,
                                    'variant'       => $variant_name[$key],
                                    'rate'          => $variant_price[$key],
                                    'sku'           => $variant_sku[$key],
                                    'qty'           => $variant_qty[$key],
                                    'image_url'     => $variant_image_url[$key],
                                    'ip_address'    => $this->ip_address,
                                    'status'        => $status,
                                ];
                                $this->productVariant->updateEntry(['id' => $variant_id[$key]], $data);
                            } else {
                                $data = [
                                    'product_id'    => $product_id,
                                    'variant'       => $variant_name[$key],
                                    'rate'          => $variant_price[$key],
                                    'sku'           => $variant_sku[$key],
                                    'qty'           => $variant_qty[$key],
                                    'image_url'     => $variant_image_url[$key],
                                    'ip_address'    => $this->ip_address,
                                    'created_at'    => $this->datetime,
                                    'status'        => $status,
                                ];
                                $this->productVariant->addEntry($data);
                            }
                        }
                    }

                    // Product Rental
                    $rental_id          = $this->request->getPost('product_rental_id');
                    $plan_name          = $this->request->getPost('plan_name');
                    $plan_duration      = $this->request->getPost('plan_duration');
                    if($plan_name) {
                        foreach ($plan_name as $key => $value) {
                            if(isset($rental_id[$key]) && $rental_id[$key]) {
                                $data = [
                                    'product_id'    => $product_id,
                                    'name'          => $plan_name[$key],
                                    'duration'      => $plan_duration[$key],
                                    'ip_address'    => $this->ip_address,
                                    'status'        => $status,
                                ];
                                $this->productRental->updateEntry(['id' => $rental_id[$key]], $data);
                            } else {
                                $data = [
                                    'product_id'    => $product_id,
                                    'name'          => $plan_name[$key],
                                    'duration'      => $plan_duration[$key],
                                    'ip_address'    => $this->ip_address,
                                    'created_at'    => $this->datetime,
                                    'status'        => $status,
                                ];
                                $this->productRental->addEntry($data);
                            }
                        }
                    }
                    $json = [
                        'message'   => "Product has been updated successfully.",
                        'status'    => true,
                        'url'       => base_url('app/product/edit?id=' . $product_id),
                    ];
                } else {
                    $json = [
                        'message'   => "Something went wrong. Please try again.",
                        'status'    => false,
                    ];
                }
            }
        } else {
            $json = [
                'message'   => "Please select a seller from seller list.",
                'status'    => false,
            ];
        }
        echo json_encode($json);
    }

    public function delete() {
        $id         = $this->request->getPost('id');
        $result     = $this->product->deleteEntry(["id" => $id]);
        if($result) {
            $json = [
                'message'   => "The selected product has been deleted successfully.",
                'status'    => true,
            ];
        } else {
            $json = [
                'message'   => "Something went wrong. Please try again.",
                'status'    => false,
            ];
        }
        echo json_encode($json);
    }

    public function combination() {
        $colors                 = $this->request->getPost('color');
        $colors_active          = $this->request->getPost('colors_active');
        $choice_attributes      = $this->request->getPost('choice_attributes');
        $price                  = $this->request->getPost('price');
        $product_name           = $this->request->getPost('name');
        $choice_no              = $this->request->getPost('choice_no');

        $options                = array();
        if ($colors_active && $colors && count($colors) > 0) {
            $colors_active = 1;
            array_push($options, $colors);
        } else {
            $colors_active = 0;
        }

        if ($choice_no) {
            foreach ($choice_no as $key => $no) {
                $_name = 'choice_options_' . $no;
                if ($this->request->getPost($_name)) {
                    $data = array();
                    foreach ($this->request->getPost($_name) as $key => $item) {
                        array_push($data, $item);
                    }
                    array_push($options, $data);
                }
            }
        }

        $combinations = generateCombination($options);
        echo $this->combinationHtml($combinations, $price, $product_name, $colors_active);
    }

    public function add_more_choice_option() {
        $attribute_id   = $this->request->getPost('attribute_id');
        $result         = $this->attributeValues->getEntryList(['attribute_id' => $attribute_id]);
        $html           = '';
        foreach ($result as $row) {
            $html .= '<option value="' . $row->value . '">' . $row->value . '</option>';
        }
        echo json_encode($html);
    }

    public function datatable() {
        $postData       = $this->request->getPost();
        $i              = $this->request->getPost('start');
        $result         = $this->productDefer->getRows($postData);
        $arrayList      = $this->getRows($i, $result);
        $output = array(
            "draw"              => $this->request->getPost('draw'),
            "recordsTotal"      => $this->productDefer->countAll($this->request->getPost()),
            "recordsFiltered"   => $this->productDefer->countFiltered($this->request->getPost()),
            "data"              => $arrayList,
        );
        echo json_encode($output);
    }

    function getRows($i, $result) {
        $arrayList = [];
        foreach($result as $row) {
            $action = ' <a href="'.base_url('app/product/edit?id=' . $row->id).'" name="btn-edit" class="btn btn-info btn-sm" data-id="'.$row->id.'" title="Edit"><i class="fas fa-edit"></i> Edit</a>';
            $action .= ' <button type="button" name="btn-delete" class="btn btn-danger btn-sm" data-id="'.$row->id.'" title="Delete"><i class="fas fa-trash"></i> Delete</button>';
            $category_ids   = json_decode($row->category_id, true);
            $categories     = [];
            foreach ($category_ids as $key => $category_id) {
                $categories [] = str_replace("-", " ", ucwords($category_id));
            }
            $arrayList [] = [
                ++$i,
                '<img src="'.showDefaultImage($row->image_url).'" alt="'.$row->name.'" class="img-fluid">',
                $row->name,
                implode(", ", $categories),
                $row->price,
                '<span class="badge '.getStatusDropdownColor()[$row->status].'">'.getActiveInactiveDropdown()[$row->status].'</span>',
                $action,
            ];
        }
        return $arrayList;
    }

    function getChoiceOptionsList($product_result) {
        $html = '';
        $attributes         = ($product_result->attributes) ? json_decode($product_result->attributes, true) : [];
        $choice_options     = ($product_result->attributes) ? json_decode($product_result->choice_options, true) : [];
        if($attributes) {
            foreach ($attributes as $key => $attribute) {
                $result             = $this->attribute->getEntry(['id' => $attribute]);
                $attrbute_result    = $this->attributeValues->getEntryList(['attribute_id' => $attribute]);
                $options_list       = [];
                foreach ($attrbute_result as $row) {
                    $options_list [$row->value] = $row->value;
                }
                $choice_options_list = [];
                foreach ($choice_options as $choice_option) {
                    if($choice_option['attribute_id'] == $attribute) {
                        $option_values = $choice_option['values'];
                        foreach ($option_values as $option_value) {
                            $choice_options_list = $option_value;
                        }
                    }
                }
                $html .= '
                <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="hidden" name="choice_no[]" value="'.$attribute.'">
                            <input type="text" class="form-control" name="choice[]" value="'.$result->name.'" placeholder="Choice Title" readonly>
                        </div>
                        <div class="col-md-8">
                        '.form_dropdown([ 'name'=>'choice_options_'.$attribute .'[]', 'id' => 'choice_options_'.$attribute, 'class' => 'form-control my-select2 attribute_choice', 'options' => $options_list, 'multiple' => 'multiple', 'selected' => $choice_options_list]).'
                        </div>
                </div>
                ';
            }
        }
        return $html;
    }

    function combinationHtml($combinations, $unit_price, $product_name, $colors_active = 0) {
        $html = '';
        if($combinations) {
            $html .= '
            <input type="hidden" name="variant_product" value="1">
            <table width="100%" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th width="30%">Variant Name</th>
                        <th width="15%">Variant Price <small class="text-danger">*</small></th>
                        <th width="15%">SKU</th>
                        <th width="15%">Quantity <small class="text-danger">*</small></th>
                        <th width="25%">Photo</th>
                        <th width="5%">#</th>
                    </tr>
                </thead>
                <tbody>
            ';
            $index = 0;
            foreach ($combinations as $key => $combination) {
                $sku = '';
                foreach (explode(' ', $product_name) as $key => $value) {
                    $sku .= substr($value, 0, 1);
                }
                $str = '';
                foreach ($combination as $key => $item){
                    if($key > 0 ){
                        $str .= '-'.str_replace(' ', '', $item);
                        $sku .='-'.str_replace(' ', '', $item);
                    } else{
                        if($colors_active == 1){
                            $color_name     = $item;
                            $str            .= $color_name;
                            $sku            .='-'.$color_name;
                        }
                        else{
                            $str .= str_replace(' ', '', $item);
                            $sku .='-'.str_replace(' ', '', $item);
                        }
                    }
                }
                if(strlen($str) > 0) {
                    $html .= '
                    <tr class="variant'.$index.'">
                        <td>
                            <label for="" class="control-label">'.$str.'</label>
                        </td>
                        <td>
                            <input type="hidden" name="variant_name[]" value="'.$str.'">
                            <input type="number" lang="en" name="variant_price[]" value="'.$unit_price.'" min="0" step="0.01" class="form-control" placeholder="Price" required>
                        </td>
                        <td>
                            <input type="text" name="variant_sku[]" value="" class="form-control">
                        </td>
                        <td>
                            <input type="number" lang="en" name="variant_qty[]" value="10" min="0" step="1" class="form-control" placeholder="Quantity" required>
                        </td>
                        <td>
                            <div class="img-div text-center btn-variantimage btn-select-variantimage" id="btn-select-variantimage" data-column="variantimage'.$index.'">  <span class="text-blue cursor-pointer img-logo" style="display: none;">Choose logo</span>
                                <span id="btn-select-variantimage" data-column="variantimage'.$index.'">
                                    <img id="img-variantimage'.$index.'" src="'.showDefaultImage().'" title="Choose logo" class="logo-display mx-auto img-fluid" >
                                </span>
                                <input type="hidden" name="variant_image_url[]" id="variantimage'.$index.'">
                                <button type="button" id="btn-remove-variantimage'.$index.'" data-column="variantimage'.$index.'" class="btn btn-sm btn-danger btn-rounded pull-right btn-remove-variantimage" title="Clear" style="display: none;"><i class="bx bx-trash-alt"></i></button>
                            </div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger btn-rounded pull-right btn-delete-variant" data-id="'.$index.'" title="Delete"><i class="bx bx-trash-alt"></i></button>
                        </td>
                    </tr>
                    ';
                }
                $index++;
            }
            $html .= '
                
                </tbody>
            </table>
            ';

        }
        return $html;
    }

    function brand_dropdown() {
        $result     = $this->brand->getEntryList(['status' => '1']);
        $list [""]  = "Select Brand";
        foreach ($result as $row) {
            $list [$row->id]    = $row->name;
        }
        return $list;
    }

    function manufacturer_dropdown() {
        $result     = $this->manufacturer->getEntryList(['status' => '1']);
        $list [""]  = "Select Manufacturer";
        foreach ($result as $row) {
            $list [$row->id]    = $row->name;
        }
        return $list;
    }

    function rental_type_dropdown() {
        $result     = $this->rentalType->getEntryList(['status' => '1']);
        $list [""]  = "Select Price Type";
        foreach ($result as $row) {
            $list [$row->id]    = $row->name;
        }
        return $list;
    }

    function color_dropdown() {
        $result     = $this->color->getEntryList(['status' => '1']);
        foreach ($result as $row) {
            $list [$row->name]    = $row->name;
        }
        return $list;
    }

    function category_dropdown($status = 0) {
        $list = [];
        if($status)
            $list[""]   = "Select Category";
        $result     = $this->category->getEntryList(['parent_id' => '0']);
        foreach($result as $row) {
            $counter = '';
            if($status) {
                $where          = 'category_id LIKE "%'.$row->slug.'%"';
                $brand_count    = $this->product->getNumRows($where);
                $counter        = ' ('.$brand_count.')';
            }
            $list [$row->slug]= $row->name . $counter;
            $list = $this->getCategoryDropdownEndNode($list, $row->id, $status);
        }
        return $list;
    }

    function getCategoryDropdownEndNode($list, $parent_id, $status = 0) {
        $subs_cats = $this->category->getEntryList(['parent_id' => $parent_id]);
        foreach ($subs_cats as $row) {
            $or_subs_cats = $this->category->getEntryList(['parent_id' => $row->id]);
            if($or_subs_cats) {
                $dot        = '--';
                $counter    = '';
                if($status) {
                    $where          = 'category_id LIKE "%'.$row->slug.'%"';
                    $brand_count    = $this->product->getNumRows($where);
                    $counter        = ' ('.$brand_count.')';
                }
                $list[$row->slug]= $dot . $row->name . $counter;
                $list = $this->getCategoryDropdownEndNode($list, $row->id, $status);
            } else {
                $dot        = '--';
                $counter    = '';
                if($status) {
                    $where          = 'category_id LIKE "%'.$row->slug.'%"';
                    $brand_count    = $this->product->getNumRows($where);
                    $counter        = ' ('.$brand_count.')';
                }
                $list[$row->slug]= $dot . $row->name . $counter;
            }  
        }
        return $list;
    }

    function attribute_dropdown() {
        $list = [];
        $result     = $this->attribute->getEntryList(['status' => '1']);
        foreach($result as $row) {
            $list [$row->id]= $row->name;
        }
        return $list;
    }
}