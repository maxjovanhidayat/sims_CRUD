<?php
namespace App\Controllers;

use App\Models\Category;
use App\Models\Produk;
use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class DashboardController extends Controller
{
    // Method to display the dashboard with products
    public function index()
    {
        $session = session();

        // Check if the user is logged in
        if (!$session->get('user_id')) {
            return redirect()->to('/login')->with('message', 'You need to log in first.');
        }

        $model = new Produk();
        $categoryModel = new Category();

        // Get categories for the dropdown
        $categories = $categoryModel->findAll();

        // Initialize the search and category filters
        $searchTerm = $this->request->getVar('search') ?? '';
        $categoryId = $this->request->getVar('category_id') ?? '';

        // Build query for filtering and search
        $builder = $model->select('produk.*, category.nama_kategori')
            ->join('category', 'category.id = produk.category_id')
            ->groupStart()
            ->like('LOWER(produk.product_name)', strtolower($searchTerm)) // Converts both to lowercase
            ->groupEnd();

        if ($categoryId) {
            $builder->where('produk.category_id', $categoryId);
        }

        // Pagination configuration
        $perPage = 10; // You can adjust this number based on how many items you want per page
        $currentPage = $this->request->getVar('page') ?? 1; // Current page from query parameter

        $products = $builder->paginate($perPage, 'default', $currentPage); // Fetch products for the current page
        $pager = $builder->pager; // Get the pager object for pagination links

        // Get the total number of items in the database (for showing total count)
        $totalItems = $builder->countAllResults(); // Total count without pagination
        $itemsOnCurrentPage = count($products); // Number of items on the current page

        // Pass the products, categories, search term, and pagination data to the view
        return view('layouts', [
            'content' => view('dashboard', [
                'products' => $products,
                'categories' => $categories,
                'searchTerm' => $searchTerm,
                'categoryId' => $categoryId,
                'pager' => $pager,
                'totalItems' => $totalItems, // Pass total items count
                'itemsOnCurrentPage' => $itemsOnCurrentPage // Pass current page items count
            ])
        ]);
    }



    // Method to show the product creation form
    public function create()
    {
        $categoryModel = new Category();
        $data['categories'] = $categoryModel->findAll();
        return view('layouts', [
            'content' => view('add_produk', [
                'categories' => $data['categories']
            ])
        ]);
    }

    // Method to store a new product
    public function store()
    {
        $produkModel = new Produk();

        // Validation
        if (
            !$this->validate([
                'product_name' => 'required|min_length[3]|max_length[255]',
                'category_id' => 'required|is_not_unique[category.id]',
                'harga_beli' => 'required|numeric',
                'harga_jual' => 'required|numeric',
                'stok' => 'required|numeric',
            ])
        ) {
            $categoryModel = new Category();
            $data['categories'] = $categoryModel->findAll();

            return view('layouts', [
                'content' => view('add_produk', [
                    'validation' => $this->validator,
                    'categories' => $data['categories'],
                ])
            ]);
        }

        // Input data
        $data_input = [
            'product_name' => $this->request->getVar('product_name'),
            'category_id' => $this->request->getVar('category_id'),
            'harga_beli' => $this->request->getVar('harga_beli'),
            'harga_jual' => $this->request->getVar('harga_jual'),
            'stok' => $this->request->getVar('stok'),
            'product_image' => $this->uploadProductImage(),
        ];

        // Save data
        $produkModel->save($data_input);

        return redirect()->to(site_url('/dashboard'))->with('message', 'Produk Berhasil Ditambahkan.');
    }

    // Method to show the edit form for an existing product
    public function edit($id)
    {
        $productModel = new Produk();
        $categoryModel = new Category();

        // Fetch product by ID
        $product = $productModel->find($id);
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
        }

        $data['product'] = $product;
        $data['categories'] = $categoryModel->findAll();

        return view('layouts', [
            'content' => view('add_produk', [
                'product' => $data['product'],
                'categories' => $data['categories'],
            ])
        ]);
    }

    // Method to update an existing product
    public function update($id)
    {
        $produkModel = new Produk();

        // Validation
        if (
            !$this->validate([
                'product_name' => 'required|min_length[3]|max_length[255]',
                'category_id' => 'required|is_not_unique[category.id]',
                'harga_beli' => 'required|numeric',
                'harga_jual' => 'required|numeric',
                'stok' => 'required|numeric',
            ])
        ) {
            $categoryModel = new Category();
            $data['categories'] = $categoryModel->findAll();

            return view('layouts', [
                'content' => view('add_produk', [
                    'validation' => $this->validator,
                    'categories' => $data['categories'],
                    'product' => $this->request->getVar()
                ])
            ]);
        }

        // Get current product details to keep the existing image if no new image is uploaded
        $product = $produkModel->find($id);
        $existingImage = $product['product_image'];

        // Input data
        $data_input = [
            'id' => $id, // Ensure we include the ID for the update
            'product_name' => $this->request->getVar('product_name'),
            'category_id' => $this->request->getVar('category_id'),
            'harga_beli' => $this->request->getVar('harga_beli'),
            'harga_jual' => $this->request->getVar('harga_jual'),
            'stok' => $this->request->getVar('stok'),
            'product_image' => $existingImage,  // Default to existing image
        ];

        // Check if a new image was uploaded
        $productImage = $this->request->getFile('product_image');
        if ($productImage && $productImage->isValid() && !$productImage->hasMoved()) {
            // Upload the new image
            $newImage = $this->uploadProductImage();
            $data_input['product_image'] = $newImage;
        }

        // Save updated product data
        $produkModel->save($data_input);

        return redirect()->to('/dashboard')->with('message', 'Produk Berhasil Diperbarui.');
    }


    // Method to delete a product
    public function delete($id)
    {
        $productModel = new Produk();
        $product = $productModel->find($id);

        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
        }

        $productModel->delete($id);
        return redirect()->to('/dashboard')->with('message', 'Produk Berhasil Dihapus');
    }

    // Helper method to upload product image
// Correct the path for uploading images within your public directory (jovan.siskuring.com)
private function uploadProductImage2($productImage = null)
{
    if (!$productImage) {
        return null;
    }

    // FCPATH points to jovan.siskuring.com, which is the public folder
    $uploadPath = FCPATH . 'uploads/product_images';  // Will point to jovan.siskuring.com/uploads/product_images

    // Ensure the directory exists
    if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0775, true);
    }

    // Generate a random name for the image
    $newName = $productImage->getRandomName();

    // Move the uploaded file to the target directory
    if ($productImage->move($uploadPath, $newName)) {
        return 'uploads/product_images/' . $newName;  // Returns the relative path
    } else {
        // Handle error if upload fails
        return 'Failed to upload the image.';
    }
}

private function uploadProductImage()
{
    // Check if the 'product_image' field exists in the request and the file is valid
    if ($this->request->getFile('product_image')->isValid()) {
        // Get the uploaded file
        $productImage = $this->request->getFile('product_image');

        // Generate a random name for the image
        $newName = $productImage->getRandomName();

        // Define the upload path (relative path from FCPATH)
        $uploadPath = FCPATH . 'uploads/product_images';

        // Ensure the directory exists
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true); // Create directory if it doesn't exist
        }

        // Move the uploaded file to the target directory
        if ($productImage->move($uploadPath, $newName)) {
            // Return the relative path of the uploaded image
            return 'uploads/product_images/' . $newName;
        } else {
            // Handle error if upload fails
            return 'Failed to upload the product image.';
        }
    }

    return null; // No image uploaded or invalid file
}

    public function export()
    {
        $model = new Produk();
        $categoryModel = new Category();

        // Get the data, including category name
        $builder = $model->select('produk.*, category.nama_kategori') // Select columns from both produk and category
            ->join('category', 'category.id = produk.category_id') // Join with the category table
            ->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header row
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Produk');
        $sheet->setCellValue('C1', 'Kategori');
        $sheet->setCellValue('D1', 'Harga Beli');
        $sheet->setCellValue('E1', 'Harga Jual');
        $sheet->setCellValue('F1', 'Stok');

        // Style for header row
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'], // White text
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FF0000'], // Red background
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'], // Black border
                ],
            ],
        ];

        // Apply style to header row
        $sheet->getStyle('A1:F1')->applyFromArray($headerStyle);

        // Populate data
        $row = 2; // Start from row 2, as row 1 is for headers
        foreach ($builder as $key => $product) {
            $sheet->setCellValue('A' . $row, $key + 1);
            $sheet->setCellValue('B' . $row, $product['product_name']);
            $sheet->setCellValue('C' . $row, $product['nama_kategori']);
            $sheet->setCellValue('D' . $row, $product['harga_beli']);
            $sheet->setCellValue('E' . $row, $product['harga_jual']);
            $sheet->setCellValue('F' . $row, $product['stok']);
            // Apply currency formatting to columns D and E (Harga Beli and Harga Jual)
            $sheet->getStyle('D' . $row)->getNumberFormat()->setFormatCode('[$Rp-421] #,##0');
            $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('[$Rp-421] #,##0');

            $row++;
        }

        // Style for body (no special styling, just borders)
        $bodyStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'], // Black border
                ],
            ],
        ];

        // Apply border style to all body rows
        $sheet->getStyle('A2:F' . ($row - 1))->applyFromArray($bodyStyle);

        // Create the writer and save the file
        $writer = new Xlsx($spreadsheet);
        $filename = 'data_produk.xlsx';

        // Send the file to the browser for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }
}
