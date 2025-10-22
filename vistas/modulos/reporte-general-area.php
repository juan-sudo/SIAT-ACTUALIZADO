<?php
// Puedes agregar aquí la lógica PHP si es necesario
?>

<div class="content-wrapper panel-medio-principal">

  <!-- 🔹 Filtro de reporte -->
  <section class="container-fluid panel-medio" style="margin-bottom: 1rem;">
    <div class="box">
      <h6>Reporte por área</h6>
    </div>

    <div class="box table-responsive">
      <div class="row">
        <div class="col-md-10">
          <table class="table-container" id="tbConsultaReporteIngresoDiario">
            <thead>
              <tr>
                <td class="text-right">Fecha de inicio</td>
                <td><input type="date" name="fechaInicioAreaRe" id="fechaInicioAreaRe"></td>

                <td class="text-right">Fecha fin</td>
                <td><input type="date" name="fechaFinAreaRe" id="fechaFinAreaRe"></td>


                <td class="text-right">Gerencia y subgerencia</td>
                <td>
                  <select name="gerenciaSubgerencia" id="gerenciaSubgerencia" class="form-select">
                    <option value="">Seleccionar gerencia o subgerencia</option>
                    <option value="3">Gerencia de Administración Tributaria</option>
                    <option value="4">Gerencia de Desarrollo Económico</option>
                    <option value="5">Gerencia de Desarrollo Social</option>
                    <option value="6">F-Gerencia de Desarrollo Territorial e Infraestructura</option>
                    <option value="7">Gerencia de Servicios Municipales y Gestión Ambiental</option>
                    <option value="11">Oficina de Administración Financiera</option>
                  
                   
                    <option value="18">Oficina General de Atención al Ciudadano y Gestión Documentaria</option>

                    
                
                    <option value="22">Subgerencia de Fiscalización</option>

                    <option value="23">Subgerencia de Programas Sociales</option>

                    <option value="24">Subgerencia de Rentas</option>

                    <option value="25">Subgerencia de Servicios Sociales</option>

                    <option value="26">Subgerencia Ambiental</option>

                    <option value="27">Subgerencia de Comercio, Licencias y Control Sanitario</option>

                    <option value="28">Subgerencia de Desarrollo Económico y Productivo</option>

                    <option value="29">Subgerencia de Desarrollo Territorial</option>

                    <option value="30">Subgerencia de Infraestructura</option>

                    <option value="31">Subgerencia de Participación y Seguridad Ciudadana</option>

                    <option value="32">Subgerencia de Servicios Municipales</option>

                    <option value="33">Oficina de Registro Civil</option>

                    <option value="34">Unidad de Transportes y Seguridad Vial</option>

                    <option value="35">Área Funcional de Mercados y Comercialización</option>

                  
                    <option value="37">Oficina de Ejecución Coactiva</option>

                    <option value="38">Oficina de Patrimonio</option>
                  </select>
                </td>




                <td>
                  <button class="btn-success" id="btnConsultarReporteArea">Consultar</button>
                </td>

              
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </section>


 <div style="max-height: 600px; overflow-y: auto;">

 

<section class="container-fluid my-4">
  <div class="row ">
    <!-- 🟢 Gráfico de Ingresos Tributarios -->
    <div class="col-lg-6 col-md-6">
   <div class="div-background col-md-8 text-center ">
        

        <h6 class="fw-bold mb-3 text-primary">Ingresos Tributarios</h6>
       
          <canvas id="myChartAdmTri" ></canvas>


        </div>
      </div>
    

    <!-- 🟣 Gráfico de Impuesto Predial + Arbitrios -->
    <div class="col-lg-6 col-md-6">
      <div class="div-background col-md-8 text-center  ">
        

    
        <h6 class="fw-bold mb-3 text-success">Impuesto Predial + Arbitrios</h6>
  
          <canvas id="myChartAdmTriImp"></canvas>
      
      
    </div>

    </div>
    
  </div>
</section>



 <section class="container-fluid panel-medio">


  <div class="row">


    <div class="col">
      <!-- Gráfico de Ingreso -->
    
      <!-- GRAFICO DE PROVEIDOS -->
      <div class="div-background col-md-9 text-center d-flex align-items-center justify-content-center">
        
        <div class="col">
          <canvas id="myChartAdmTriProveido" ></canvas>
        </div>

          <div class="col d-flex justify-content-center mt-3">
        <div class="card shadow-sm border-0 rounded-4" style="max-width: 320px; background: linear-gradient(135deg, #f8f9fa, #e9ecef);">
         
        <div class="card-body text-center">
           
            <h4 id="totalAdmTriPro" class="fw-bold text-primary mb-0"></h4>
          </div>
        </div>
      </div>

        
      </div>
    </div>

    



  </div>
</section>

<section class="container-fluid panel-medio">
  <div class="row">
    <div 
      class="col" 
      style="display: flex; justify-content: flex-end; align-items: center; padding-right: 20px;">
      
      <button 
        onclick="descargarExcel()"
        style="
          display: flex; 
          align-items: center; 
          justify-content: center;
          background: linear-gradient(135deg, #28a745, #20c997);
          color: #fff;
          font-weight: 600;
          border: none;
          border-radius: 12px;
          padding: 10px 18px;
          box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
          transition: all 0.3s ease;
          cursor: pointer;
        "
        onmouseover="this.style.background='linear-gradient(135deg, #20c997, #1e7e34)'; this.style.transform='translateY(-2px)';"
        onmouseout="this.style.background='linear-gradient(135deg, #28a745, #20c997)'; this.style.transform='translateY(0)';"
      >
        <img 
          src="./vistas/img/iconos/excel.svg" 
          alt="icono excel"
          style="width: 22px; height: 22px; margin-right: 10px; filter: brightness(0) invert(1);"
        >
        Exportar en Excel
      </button>

    </div>
  </div>
</section>



       
   </div> 

</div>

<!-- 🔹 Modal cargando -->
<?php include_once "modalcargar.php"; ?>