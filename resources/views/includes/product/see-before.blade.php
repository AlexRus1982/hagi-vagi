<div class="py-2 w-100">
    <div class="d-flex flex-row w-100 fs-4 mt-0 mb-1 fw-bold">Смотрели ранее</div>
    @php
        // generate data by accessing properties https://github.com/fzaninotto/Faker
        /*
        $faker = Faker\Factory::create();
        echo $faker->name;
        echo $faker->address;
        echo $faker->sentence($nbWords = 600, $variableNbWords = true);
        //*/

        $hits = DB::table('catalog')->inRandomOrder()->take(6)->get();
    @endphp

    <div class="d-flex flex-row w-100 justify-content-between flex-wrap border-bottom pb-3">
        @foreach($hits as $key=>$value)
            @include('includes.product.mini-card', ['value' => $value])
        @endforeach
    </div>
</div>