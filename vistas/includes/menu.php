<aside class="main-sidebar">

	 <section class="sidebar">

		<ul class="sidebar-menu">

		<?php

		if($_SESSION["perfil"] == "Administrador"){

			echo '<li class="active">

				<a href="inicio">

					<i class="fa fa-home"></i>
					<span>Inicio</span>

				</a>

			</li>

			<li>

				<a href="usuarios">

					<i class="fa fa-user"></i>
					<span>Usuarios</span>

				</a>

			</li>';

		}

		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Especial"){

			echo '<li>

				<a href="categorias">

					<i class="fa fa-th"></i>
					<span>Categorías</span>

				</a>

			</li>

			<li>

				<a href="productos">

					<i class="fa fa-product-hunt"></i>
					<span>Productos</span>

				</a>

			</li>';

		}

		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Funcionario"){

			echo '<li>

				<a href="instructores">

					<i class="fa fa-users"></i>
					<span>Instructores</span>

				</a>

			</li>';

		}

		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Funcionario"){

			echo '<li class="treeview">

				<a href="#">

					<i class="fa fa-list-ul"></i>
					
					<span>Prestamos</span>
					
					<span class="pull-right-container">
					
						<i class="fa fa-angle-left pull-right"></i>

					</span>

				</a>

				<ul class="treeview-menu">
					
					<li>

						<a href="prestamos">
							
							<i class="fa fa-circle-o"></i>
							<span>Administrar Prestamos</span>

						</a>

					</li>

					<li>

						<a href="crear-prestamo">
							
							<i class="fa fa-circle-o"></i>
							<span>Crear Prestamo</span>

						</a>

					</li>';

					if($_SESSION["perfil"] == "Administrador"){

					echo '<li>

						<a href="reportes">
							
							<i class="fa fa-circle-o"></i>
							<span>Reporte de Prestamos</span>

						</a>

					</li>';

					}

				

				echo '</ul>

			</li>';

		}
		// Opción de inventario
		
		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Funcionario"){

			echo '<li class="treeview">

				<a href="#">

					<i class="fa fa-list-ul"></i>
					
					<span>Movimientos</span>
					
					<span class="pull-right-container">
					
						<i class="fa fa-angle-left pull-right"></i>

					</span>

				</a>
                
				<ul class="treeview-menu">
					
					<li>
					
			  
					       <a >	

					        
							
							<i class="fa fa-circle-o"></i>
							<span>Administrar movimientos</span>
                            </a>
						

					</li>

					<li>

						<a href="adicionar-movimiento">
							
							<i class="fa fa-circle-o"></i>
							<span>Adicionar movimiento</span>

						</a>

					</li>';

					
				

				echo '</ul>

			</li>';

		}

		// fin opción de inventario

		?>

		</ul>

	 </section>

</aside>