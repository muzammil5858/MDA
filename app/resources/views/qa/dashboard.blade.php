<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <style>
        
       .title h3{
            font-size:1.6vw !important;
            
            font-weight:bold;
            padding:10px;
        }
        .inner h3{
            font-size:1.5rem !important;

        }
        .inner p{
            font-size:1.1rem !important;
        }
        h4{
            font-size:1.2vw !important;
        }
    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="row mt-2" >
                    <div class="col title" style="display:flex;justify-content:center;">
                        <h3> Statistical Information of Registered Data Entries</h3>
                    </div>
                </div>
                <div class="row px-2 py-3">
                    <div class="col-lg-4 col-6">
                      <!-- small card -->
                      <div class="small-box bg-info">
                        <div class="inner">
                          <h3>INDEX</h3>
                          <p id="scan">Pages :  <?php echo number_format($entries[0]->indexing) ?></p>
                        </div>
                        <div class="icon">
                          {{-- <i class="fas fa-shopping-cart"></i> --}}
                        </div>
                        
                      </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-6">
                      <!-- small card -->
                      <div class="small-box bg-success">
                        <div class="inner">
                          <h3 >Data Entry</h4>
                          <p style="display: inline-block" id="indexe">Completed Entries: <a href="/daily-detail/index"> <?php echo number_format($entries[0]->entries) ?></a></p>
                        </div>
                        <div class="icon">
                          {{-- <i class="ion ion-stats-bars"></i> --}}
                        </div>
                       
                      </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-6">
                      <!-- small card -->
                      <div class="small-box bg-warning">
                        <div class="inner">
                          <h3 >Entries QA</h3>
                          <p id="entries">QA Done : <a href="/daily-detail/qa"> <?php echo number_format(0) ?></a>  </p>
                        </div>
                        <div class="icon">
                          {{-- <i class="fas fa-user-plus"></i> bn --}}
                        </div>
                        
                      </div>
                    </div>
                   
                  </div>
            </div>
        </div>
    </div>
</x-app-layout>
