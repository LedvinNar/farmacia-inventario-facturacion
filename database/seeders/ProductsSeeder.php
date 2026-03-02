<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Mapa: slug => id
        $categories = DB::table('categories')->pluck('id', 'slug');
        $brands     = DB::table('brands')->pluck('id', 'slug');

        // Productos realistas (20)
        $products = [
            ['sku'=>'PRD-0001','name'=>'Paracetamol 500 mg (Tabletas x 10)','description'=>'Analgésico y antipirético. Caja con 10 tabletas.','category_slug'=>'analgesicos','brand_slug'=>'teva','purchase'=>18.00,'sale'=>25.00,'stock'=>60,'min'=>10,'expires'=>'2027-06-30'],
            ['sku'=>'PRD-0002','name'=>'Ibuprofeno 400 mg (Tabletas x 10)','description'=>'Antiinflamatorio y analgésico. Caja con 10 tabletas.','category_slug'=>'antiinflamatorios','brand_slug'=>'abbott','purchase'=>22.00,'sale'=>30.00,'stock'=>55,'min'=>10,'expires'=>'2027-04-30'],
            ['sku'=>'PRD-0003','name'=>'Diclofenaco 50 mg (Tabletas x 10)','description'=>'Antiinflamatorio para dolor muscular y articular.','category_slug'=>'antiinflamatorios','brand_slug'=>'novartis','purchase'=>25.00,'sale'=>35.00,'stock'=>40,'min'=>8,'expires'=>'2027-03-31'],
            ['sku'=>'PRD-0004','name'=>'Naproxeno 500 mg (Tabletas x 10)','description'=>'Antiinflamatorio no esteroideo. Caja con 10 tabletas.','category_slug'=>'antiinflamatorios','brand_slug'=>'pfizer','purchase'=>30.00,'sale'=>42.00,'stock'=>30,'min'=>6,'expires'=>'2027-05-31'],

            ['sku'=>'PRD-0005','name'=>'Amoxicilina 500 mg (Cápsulas x 12)','description'=>'Antibiótico de amplio espectro. Caja con 12 cápsulas.','category_slug'=>'antibioticos','brand_slug'=>'gsk','purchase'=>45.00,'sale'=>60.00,'stock'=>25,'min'=>5,'expires'=>'2027-02-28'],
            ['sku'=>'PRD-0006','name'=>'Azitromicina 500 mg (Tabletas x 3)','description'=>'Antibiótico macrólido. Caja con 3 tabletas.','category_slug'=>'antibioticos','brand_slug'=>'pfizer','purchase'=>75.00,'sale'=>95.00,'stock'=>20,'min'=>4,'expires'=>'2027-01-31'],
            ['sku'=>'PRD-0007','name'=>'Cefalexina 500 mg (Cápsulas x 12)','description'=>'Antibiótico cefalosporina. Caja con 12 cápsulas.','category_slug'=>'antibioticos','brand_slug'=>'sanofi','purchase'=>55.00,'sale'=>72.00,'stock'=>18,'min'=>4,'expires'=>'2027-07-31'],

            ['sku'=>'PRD-0008','name'=>'Ambroxol Jarabe 15 mg/5 ml (120 ml)','description'=>'Mucolítico/expectorante. Frasco 120 ml.','category_slug'=>'jarabes','brand_slug'=>'bayer','purchase'=>40.00,'sale'=>55.00,'stock'=>22,'min'=>5,'expires'=>'2026-12-31'],
            ['sku'=>'PRD-0009','name'=>'Loratadina Jarabe 1 mg/ml (60 ml)','description'=>'Antialérgico. Frasco 60 ml.','category_slug'=>'antialergicos','brand_slug'=>'johnson-&-johnson','purchase'=>38.00,'sale'=>50.00,'stock'=>18,'min'=>4,'expires'=>'2027-08-31'],

            ['sku'=>'PRD-0010','name'=>'Vitamina C 500 mg (Tabletas x 20)','description'=>'Suplemento de vitamina C. Presentación x 20 tabletas.','category_slug'=>'vitaminas-y-suplementos','brand_slug'=>'bayer','purchase'=>35.00,'sale'=>48.00,'stock'=>45,'min'=>10,'expires'=>'2027-10-31'],
            ['sku'=>'PRD-0011','name'=>'Complejo B (Tabletas x 30)','description'=>'Suplemento de vitaminas del complejo B. 30 tabletas.','category_slug'=>'vitaminas-y-suplementos','brand_slug'=>'merck','purchase'=>55.00,'sale'=>75.00,'stock'=>35,'min'=>8,'expires'=>'2027-09-30'],

            ['sku'=>'PRD-0012','name'=>'Clotrimazol Crema 1% (20 g)','description'=>'Antimicótico tópico. Tubo 20 g.','category_slug'=>'cremas-y-pomadas','brand_slug'=>'bayer','purchase'=>28.00,'sale'=>40.00,'stock'=>28,'min'=>6,'expires'=>'2027-11-30'],
            ['sku'=>'PRD-0013','name'=>'Hidrocortisona Crema 1% (15 g)','description'=>'Corticoide tópico. Tubo 15 g.','category_slug'=>'cremas-y-pomadas','brand_slug'=>'pfizer','purchase'=>32.00,'sale'=>45.00,'stock'=>20,'min'=>5,'expires'=>'2027-06-30'],

            ['sku'=>'PRD-0014','name'=>'Omeprazol 20 mg (Cápsulas x 14)','description'=>'Inhibidor de bomba de protones. Caja x 14 cápsulas.','category_slug'=>'gastrointestinal','brand_slug'=>'astrazeneca','purchase'=>65.00,'sale'=>85.00,'stock'=>30,'min'=>6,'expires'=>'2027-05-31'],
            ['sku'=>'PRD-0015','name'=>'Sales de Rehidratación Oral (Sobre)','description'=>'Sobre para rehidratación oral.','category_slug'=>'gastrointestinal','brand_slug'=>'sanofi','purchase'=>6.00,'sale'=>10.00,'stock'=>120,'min'=>20,'expires'=>'2027-12-31'],

            ['sku'=>'PRD-0016','name'=>'Salbutamol Inhalador 100 mcg/dosis','description'=>'Broncodilatador. Inhalador dosificador.','category_slug'=>'respiratorio','brand_slug'=>'gsk','purchase'=>120.00,'sale'=>150.00,'stock'=>12,'min'=>3,'expires'=>'2027-03-31'],

            ['sku'=>'PRD-0017','name'=>'Gotas Óticas (10 ml)','description'=>'Gotas para oído. Frasco 10 ml.','category_slug'=>'otologicos','brand_slug'=>'novartis','purchase'=>65.00,'sale'=>85.00,'stock'=>10,'min'=>2,'expires'=>'2027-02-28'],
            ['sku'=>'PRD-0018','name'=>'Lágrimas Artificiales (15 ml)','description'=>'Solución lubricante ocular. Frasco 15 ml.','category_slug'=>'oftalmicos','brand_slug'=>'johnson-&-johnson','purchase'=>70.00,'sale'=>95.00,'stock'=>14,'min'=>3,'expires'=>'2027-08-31'],

            ['sku'=>'PRD-0019','name'=>'Alcohol Antiséptico 70% (120 ml)','description'=>'Uso externo. Antiséptico. Frasco 120 ml.','category_slug'=>'higiene-personal','brand_slug'=>'p&g','purchase'=>22.00,'sale'=>30.00,'stock'=>50,'min'=>10,'expires'=>'2028-01-31'],
            ['sku'=>'PRD-0020','name'=>'Jabón Antibacterial (Barra)','description'=>'Jabón para higiene diaria.','category_slug'=>'higiene-personal','brand_slug'=>'p&g','purchase'=>12.00,'sale'=>18.00,'stock'=>80,'min'=>15,'expires'=>'2028-06-30'],
        ];

        foreach ($products as $p) {
            $categoryId = $categories[$p['category_slug']] ?? null;
            $brandId    = $brands[$p['brand_slug']] ?? null;

            // Si no existe el slug en tu BD, lo saltamos para evitar error de FK
            if (!$categoryId || !$brandId) {
                continue;
            }

            DB::table('products')->insert([
                'sku'            => $p['sku'],
                'name'           => $p['name'],
                'description'    => $p['description'],
                'category_id'    => $categoryId,
                'brand_id'       => $brandId,
                'purchase_price' => $p['purchase'],
                'sale_price'     => $p['sale'],
                'stock'          => $p['stock'],
                'stock_min'      => $p['min'],
                'expires_at'     => $p['expires'],
                'is_active'      => 1,
                'created_at'     => $now,
                'updated_at'     => $now,
            ]);
        }
    }
}
