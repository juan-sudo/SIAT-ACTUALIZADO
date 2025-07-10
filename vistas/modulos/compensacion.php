<?php
use Controladores\ControladorEmpresa;
use Controladores\ControladorPredio;
use Controladores\ControladorContribuyente;
?>

<div class="content-wrapper panel-medio-principal">
  <section class="container-fluid panel-medio">
      <div class="box"><h6>Compensacion</h6></div> 
  </section>
<!-- seccion de la Id-->
  <section class="container-fluid panel-medio">
        <div class="row">
            <div class="col">

                <div class="table-responsive col-md-5 div-background">

                            <div class="col-md-12"> 
                                    <span class="caption_"> 
                                         Deudas pagadas origen
                                    </span>   

                                      <div class="pull-right" style="margin-left: 10px;">
                                      <label for="fecha_filtro_fin_a_origen" style="margin-right: 5px;"> Buscar por carpeta <i class="bi bi-search"></i> </label>
                                      <input  type="text" id="fecha_filtro_fin_a_origen" name="fecha_filtro_fin_a_origen">
                                    </div>

                                   

                                  

                                    
                            </div>

                            <div class="col-md-12"> 

                            <div class="">
                              Propietarios
                            </div>
                            <table id="tabla_contribuyente_predio_origen" class="table-container">
                              <thead>
                                <tr>
                                  <th class="text-center">Código</th>
                                  <th class="text-center">Documento</th>
                                  <th class="text-center">Nombres</th>
                                  
                                </tr>
                              </thead>
                              <tbody id="div_propietario2">
                                <!-- Aquí se agregarán los propietarios en filas -->
                              </tbody>
                            </table>

                            </div>


                            <div class="">
                              Esatdo de cuentas pagados
                            </div>
                            <div class="box div_1 table-responsive_i">
                            <table class="table-container" id="tabla_extorno_origen">
                              <thead>
                                <tr>
                                  <th class="text-center" style="width: 80px;">Cod.</th> 
                                  <th class="text-center" style="width: 50px;">Tributo</th>
                                  <th class="text-center" style="width: 50px;">Año</th>
                                  <th class="text-center" style="width: 50px;">Periodo</th>
                                   <th class="text-center" style="width: 50px;">Importe</th>
                                 
                                
                                </tr>
                                
                              </thead>

                              <tbody id="compensacion_origen">
                                <!-- Aqui Aparecen el estado de cuenta Agua-->
                                <tr id='437'>
                                   <td style="text-align: center;">006</td>
                                   <td style="text-align: center;">Imp. predial</td>
                                   <td style="text-align: center;">2020</td>
                                    <td style="text-align: center;">1</td>
                                    <td style="text-align: center;">50.00</td>
                                 </tr>


                                  <tr id='432'>
                                 <td style="text-align: center;">006</td>
                                  <td style="text-align: center;">Imp. predial</td>
                                   <td style="text-align: center;">2020</td>
                                    <td style="text-align: center;">1</td>
                                    <td style="text-align: center;">50.00</td>


                                 </tr>


                                  <tr id='451'>
                                 <td style="text-align: center;">006</td>
                                  <td style="text-align: center;">Imp. predial</td>
                                   <td style="text-align: center;">2020</td>
                                    <td style="text-align: center;">1</td>
                                    <td style="text-align: center;">50.00</td>


                                 </tr>




                              </tbody>


                            </table>
                            </div>


                </div>

                
                <div class="table-responsive col-md-2 div-background">

                <div class="row">
                 <button id="btn-agregar">Agregar</button>

                </div>


                <div class="row">
                   <button id="btn-quitar">Quitar</button>
                  

                </div>

                
               

                </div>



                <div class="table-responsive col-md-5 div-background">

                            <div class="col-md-12"> 
                                    <span class="caption_"> 
                                        Deudas pagadas destino
                                    </span>   

                                    <div class="pull-right" style="margin-left: 10px;">
                                      <label for="fecha_filtro_fin_a_destino" style="margin-right: 5px;"> Buscar por carpeta <i class="bi bi-search"></i> </label>
                                      <input  type="text" id="fecha_filtro_fin_a_destino" name="fecha_filtro_fin_a_destino">
                                    </div>
    
                            </div>

                            <div class="col-md-12"> 

                            <div class="">
                              Propietarios
                            </div>
                            <table id="tabla_contribuyente_predio_destino" class="table-container">
                              <thead>
                                <tr>
                                  <th class="text-center">Código</th>
                                  <th class="text-center">Documento</th>
                                  <th class="text-center">Nombres</th>
                                  
                                </tr>
                              </thead>
                              <tbody id="div_propietario2">
                                <!-- Aquí se agregarán los propietarios en filas -->

                              </tbody>
                            </table>

                            </div>
                            <div class="box div_1 table-responsive_i">
                            <table class="table-container " id="tabla_extorno_destino">
                              <thead>
                               <tr>
                                  <th class="text-center" style="width: 80px;">Cod.</th> 
                                  <th class="text-center" style="width: 50px;">Tributo</th>
                                  <th class="text-center" style="width: 50px;">Año</th>
                                  <th class="text-center" style="width: 50px;">Periodo</th>
                                   <th class="text-center" style="width: 50px;">Importe</th>
                                 
                                
                                </tr>
                              </thead>

                            
                              <tbody id="compensacion_destino" >

                               <tr id='452'>
                                 <td style="text-align: center;">006</td>
                                  <td style="text-align: center;">Imp. predial</td>
                                   <td style="text-align: center;">2020</td>
                                    <td style="text-align: center;">1</td>
                                    <td style="text-align: center;">50.00</td>
                                 </tr>
                                <!-- Aqui Aparecen el estado de cuenta Agua-->
                              </tbody>

                              


                            </table>
                            </div>
                </div>


            </div>
      </div>
        
        </div>
      </div>
    </div>
  </section>
</div>

