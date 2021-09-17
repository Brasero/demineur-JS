<?php

if(isset($_POST['taille']) && isset($_POST['level']) && $_POST['taille'] != '')
	{	
		$taille = $_POST['taille'];
		$level = $_POST['level'];
		$head = $taille / 3;
		$place = 1;

		echo '<table><tbody id="table"><th colspan="'.$head.'" id="coup"></th><th colspan="'.$head.'" id="time"></th><th colspan="'.$head.'" id="drap"></th>';
		for($i=1; $i<=$taille; $i++)
			{	
				echo '<tr>';

				for($j=1; $j<=$taille; $j++)
					{	
						echo '<td id="'.$place.'" oncontextmenu="drapeau(this)" onclick="bombe(this)" class="case" style="background: grey;" value="0"></td>';
						$place++;
					}

				echo '</tr>';
			}

		echo '</tbody></table>';

	}

		if(isset($level))
			{
				for($i=1; $i<=5; $i++)
					{	
						if($level == ''.$i.'')
							{	
								$diff = ($i * 10);
								break;
							}
					}
			}

		if(isset($taille))
			{
				$nbBombe = floor((($taille * $taille) * $diff) / 100);
				$tab = $taille * $taille;
				$bombe = [];
				for($i=1; $i<=$nbBombe; $i++)
					{
						$test = floor(rand(1, $tab));

						for($j=0; $j<=$nbBombe; $j++)
							{	
								if(isset($bombe[$j]))
									{
										if ($test == $bombe[$j])
											{	
												$ve = false;
												break;
											}

										else
											{
												$ve = true;
											}
									}
								else
									{	
										$ve = true;
									}
							}
						
						if($ve == true)
						{
						$bombe[$i] = $test;
						}

						else
						{
							$i--;
						}
					}
			}





?>


<form method="post" action="index.php">
	<label for="taille">Taille du carré : </label>
	<input type="number" name="taille" id="taille" placeholder="taille de grille" max="30" value="9" step="3" />
	<label for="level">Niveau de difficulté : </label>
	<select name="level" id="level">
		<option value="1">Easy</option>
		<option value="2" selected>Normal</option>
		<option value="3">Médium</option>
		<option value="4">Hard</option>
		<option value="5">Insane</option>
	</select>
	<input type="submit" id="submit" value="valider" />
</form>


<script type="text/javascript">

			document.addEventListener("contextmenu", function(event){event.preventDefault();});
			var table = document.getElementById('table');
			table.addEventListener('click', verifyAll);
			
			var timeInput = document.getElementById('time');
			var h = 0;
			var m = 0; 
			var s = 0;
			var ms = 0;
			var t;
			var debut = '';
			var actual = '';
			var hautDroit = '';
			var basGauche = '';
			var victory = 0;
			var count = 0;
			var place = [];
			var regex = /<?php if(isset($bombe)){ $i=1; foreach($bombe as $bombeplace){if($i == $nbBombe){echo '(?<!\d)('.$bombeplace.')(?!\d)';$i++;} else{echo '(?<!\d)('.$bombeplace.')(?!\d)|';$i++;}}} ?>/;
			var coup = document.getElementById('coup');
			var drap = document.getElementById('drap');
			var click = 0;
			var coup = document.getElementById('coup');
			var restant = <?php if(isset($nbBombe)){ echo $nbBombe; } ?> - victory;
			drap.innerHTML = 'Bombe : '+restant;
			var check = [];
			check[0] = '';

			function drapeau(a)
				{

					if(a.attributes.value.value == "0")	
						{	
						a.style.background = 'url("img/drapeau.gif") no-repeat';
						a.style.backgroundSize = 'cover';
						a.attributes.value.value = 1;
						place[victory] = a.getAttribute('id');
						victory++;
						restant = <?php if(isset($nbBombe)){ echo $nbBombe; } ?> - victory;
						drap.innerHTML = 'Bombe : '+restant;
						}

					else if(a.attributes.value.value == "1")
						{	
							a.style.background = 'grey';
							a.innerHTML = '?';
							a.attributes.value.value = 2;
							victory--;
							restant = <?php if(isset($nbBombe)){ echo $nbBombe; } ?> - victory;
							place[victory] = '';
							drap.innerHTML = 'Bombe : '+restant;
						}

					else if(a.attributes.value.value == "2")
						{	
							a.style.background = 'grey';
							a.innerHTML = '';
							a.attributes.value.value = 0;
						}

					for(var i = 0; i < victory; i++)
						{	
							if(place[i].match(regex))
								{	
									var victoire = true;
								}

							else
								{	
									var victoire = false;
									break;
								}
						}


					if(victory == <?php if(isset($nbBombe)){ echo $nbBombe; } ?> && victoire)
						{
							for (var i=1; i<=<?php echo $tab; ?>; i++)
									{	
										if(document.getElementById(i).getAttribute('id').match(regex))
											{	
												document.getElementById(i).style.background = 'url("img/mine.jpg") no-repeat';
												document.getElementById(i).style.backgroundSize = 'cover';
												document.getElementById(i).style.border = '1px solid gray';
											}

										else
											{	
												document.getElementById(i).style.background = 'silver';
												document.getElementById(i).style.border = '1px solid gray';
											}
									}
							drap.innerHTML = 'VICTOIRE !';
							drap.style.background = 'lime';
							drap.style.color = 'white';
							stop();
						}

					return victory;
				}
			
			function bombe(a) 
			{ 
				var ID = a.getAttribute('id');
				var tab = <?php if(isset($tab)){ echo $tab; } ?>;
				var y = parseInt(ID);
				var taille = parseInt(<?php if(isset($taille)){ echo $taille; }?>);
				var haut = document.getElementById(y-taille);
				var hautVerif = false;
				var bas = document.getElementById(y+taille);
				var basVerif = false;
				var droite = document.getElementById(y+1);
				var droiteVerif = false;
				var gauche = document.getElementById(y-1);
				var gaucheVerif = false;
				hautDroit = document.getElementById(y-taille+1);
				var hautDroitVerif = false;
				var hautGauche = document.getElementById(y-taille-1);
				var hautGaucheVerif = false;
				var basDroit = document.getElementById(y+taille+1);
				var basDroitVerif = false;
				basGauche = document.getElementById(y+taille-1);
				var basGaucheVerif = false;
				var prox = 0;
				

					if(a.style.background != 'silver'){
						if (ID.match(regex) && a.attributes.value.value == '0')
							{	
								drap.innerHTML = "PERDU !";
								drap.style.background = 'red';
								drap.style.color = 'white';
								stop();
								for (var i=1; i<=<?php echo $tab; ?>; i++)
									{	
										if(document.getElementById(i).getAttribute('id').match(regex))
											{	
												document.getElementById(i).style.background = 'url("img/mine.jpg") no-repeat';
												document.getElementById(i).style.backgroundSize = 'cover';
												document.getElementById(i).style.border = '1px solid gray';
											}

										else
											{	
												document.getElementById(i).style.background = 'silver';
												document.getElementById(i).style.border = '1px solid gray';
											}
									}
							}

						else if(a.attributes.value.value == '0')
							{	
								a.style.background = 'silver';
								a.style.border = '1px solid grey';

								if((y-taille) > 0)
									{	
										if(haut.getAttribute('id').match(regex))
											{	
												prox++;
											}

										else if(haut.attributes.value.value == '0')
											{	
												haut.style.background = 'silver';
												haut.style.border = '1px solid grey';
												hautVerif = true;
												
											}
									}

								if((y+taille) < tab + 1)
									{		
										if(bas.getAttribute('id').match(regex))
											{	
												prox++;
											}

										else if(bas.attributes.value.value == '0')
											{	
												bas.style.background = 'silver';
												bas.style.border = '1px solid grey';
												basVerif = true;
												
											}
									}

								if((y%taille) != 0)
									{	
										if(droite.getAttribute('id').match(regex) )
											{	
												prox++;
											}

										else if(droite.attributes.value.value == '0')
											{	
												droite.style.background = 'silver';
												droite.style.border = '1px solid grey';
												droiteVerif = true;
												
											}
									}

								if(((y-1)%taille) != 0)
									{	
										if(gauche.getAttribute('id').match(regex))
											{	
												prox++;
											}

										else if(gauche.attributes.value.value == '0')
											{	
												gauche.style.background = 'silver';
												gauche.style.border = '1px solid grey';
												gaucheVerif = true;
												
											}
									}

								if((y-taille) > 0 && (y%taille) != 0)
									{	
			
										if(hautDroit.getAttribute('id').match(regex))
											{	
												prox++;
											}

										else if(hautDroit.attributes.value.value == '0')
											{	
												hautDroit.style.background = 'silver';
												hautDroit.style.border = '1px solid grey';
												hautDroitVerif = true;
												
											}
									}

								if((y-taille) > 0 && ((y-1)%taille) != 0)
									{	
										if(hautGauche.getAttribute('id').match(regex))
											{	
												prox++;
											}

										else if(hautGauche.attributes.value.value == '0')
											{	
												hautGauche.style.background = 'silver';
												hautGauche.style.border = '1px solid grey';
												hautGaucheVerif = true;
												
											}
									}

								if((y+taille) < tab && (y%taille) != 0)
									{	
										if(basDroit.getAttribute('id').match(regex))
											{	
												prox++;
											}

										else if(basDroit.attributes.value.value == '0')
											{	
												basDroit.style.background = 'silver';
												basDroit.style.border = '1px solid grey';
												basDroitVerif = true;
												
											}
									}

								if((y+taille) < tab && ((y-1)%taille) != 0)
									{	
										if(basGauche.getAttribute('id').match(regex))
											{	
												prox++;
											}

										else if(basGauche.attributes.value.value == '0')
											{	
												basGauche.style.background = 'silver';
												basGauche.style.border = '1px solid grey';
												basGaucheVerif = true;
												
											}
									}

									

									count++;
									

								if(prox != 0)
									{	
										a.textContent = prox;
									}

								if(prox == 1)
									{	
										a.style.color = "navy";
									}

								if(prox == 2)
									{	
										a.style.color = "red";
									}

								if(prox == 3)
									{	
										a.style.color = "purple";
									}

								if(prox == 4)
									{	
										a.style.color = "orange";
									}

								if(prox == 5)
									{	
										a.style.color = "yellow";
									}

								if(prox == 6)
									{	
										a.style.color = "aqua";
									}

								if(prox == 7)
									{	
										a.style.color = "fuchsia";
									}

								if(prox == 8)
									{	
										a.style.color = "maroon";
									}

								if(prox == 9)
									{	
										a.style.color = "olive";
									}

							}


						if(hautVerif && (count == 1 || count == 4) && haut.attributes.value.value == '0')
							{	
								bombe(haut);
							}

						else if(count == 1 || count == 4)
							{	
								count++;
							}
						

						if(basVerif && (count == 2 || count == 3) && bas.attributes.value.value == '0')
							{	
								bombe(bas);
							}

						else if(count == 2 || count == 3)
							{	
								count++;
							}
						

						if(droiteVerif && (count == 5 || count == 8) && droite.attributes.value.value == '0')
							{	
								bombe(droite);
							}

						else if(count == 5 || count == 8)
							{	
								count++;
							}
						

						if(gaucheVerif && (count == 6 || count == 7) && gauche.attributes.value.value == '0')
							{	
								bombe(gauche);
							}

						else if(count == 6 || count == 7)
							{	
								count++;
							}
						

						if(hautDroitVerif && (count == 9 || count == 12) && hautDroit.attributes.value.value == '0')
							{	
								bombe(hautDroit);
							}

						else if(count == 9 || count == 12)
							{	
								count++;
							}

						if(basGaucheVerif && (count == 10 || count == 11) && basGauche.attributes.value.value == '0')
							{	
								bombe(basGauche);
							}

						else if(count == 10 || count == 11)
							{	
								count++;
							}
						

						if(hautGaucheVerif && (count == 13 || count == 16) && hautGauche.attributes.value.value == '0')
							{	
								bombe(hautGauche);
							}

						else if(count == 13 || count == 16)
							{	
								count++;
							}
						

						if(basDroitVerif && (count == 14 || count == 15) && basDroit.attributes.value.value == '0')
							{	
								bombe(basDroit);
							}
						
						else if(count == 14 || count == 15)
							{	
								count++;
							}


						if(count > 16)
							{	
								for (var i=1; i<=<?php echo $tab; ?>; i++)
									{	
										var verify = document.getElementById(i);
										if(!verify.getAttribute('id').match(regex) && verify.style.background != 'grey')
											{	
												if(!check.includes(verify))
													{	
														check[i] = verify;
														console.log(check);
														console.log(verify.style.background);
														bombe2(document.getElementById(i));
													}
											}
									}
								count = 0;		
							}
						}

						else{
							for (var i=1; i<=<?php echo $tab; ?>; i++)
									{	
										var verify = document.getElementById(i);
										if(!verify.getAttribute('id').match(regex) && verify.style.background != 'grey')
											{	
												if(!check.includes(verify))
													{	
														check[i] = verify;
														console.log(check);
														console.log(verify.style.background);
														bombe2(document.getElementById(i));
													}
											}
									}
						}

			}

			function verifyAll()
				{	
					if(click == 0)
						{	
							start();
						}
					click++;
					coup.innerHTML = click+' coup';
				}

				

				function bombe2(a)
					{

						var ID = a.getAttribute('id');
						var tab = <?php if(isset($tab)){ echo $tab; } ?>;
						var y = parseInt(ID);
						var taille = parseInt(<?php if(isset($taille)){ echo $taille; }?>);
						var haut = document.getElementById(y-taille);
						var hautVerif = false;
						var bas = document.getElementById(y+taille);
						var droite = document.getElementById(y+1);
						var gauche = document.getElementById(y-1);
						hautDroit = document.getElementById(y-taille+1);
						var hautGauche = document.getElementById(y-taille-1);
						var basDroit = document.getElementById(y+taille+1);
						basGauche = document.getElementById(y+taille-1);
						var prox = 0;

						if(a.attributes.value.value == '0')
							{	
							

								if((y-taille) > 0)
									{	
										if(haut.getAttribute('id').match(regex))
											{	
												prox++;
											}
									}

								if((y+taille) < tab + 1)
									{		
										if(bas.getAttribute('id').match(regex))
											{	
												prox++;
											}
									}

								if((y%taille) != 0)
									{	
										if(droite.getAttribute('id').match(regex) )
											{	
												prox++;
											}
									}

								if(((y-1)%taille) != 0)
									{	
										if(gauche.getAttribute('id').match(regex))
											{	
												prox++;
											}
									}

								if((y-taille) > 0 && (y%taille) != 0)
									{	
			
										if(hautDroit.getAttribute('id').match(regex))
											{	
												prox++;
											}
									}

								if((y-taille) > 0 && ((y-1)%taille) != 0)
									{	
										if(hautGauche.getAttribute('id').match(regex))
											{	
												prox++;
											}
									}

								if((y+taille) < tab && (y%taille) != 0)
									{	
										if(basDroit.getAttribute('id').match(regex))
											{	
												prox++;
											}
									}

								if((y+taille) < tab && ((y-1)%taille) != 0)
									{	
										if(basGauche.getAttribute('id').match(regex))
											{	
												prox++;
											}
									}
									

								if(prox != 0)
									{	
										a.textContent = prox;
									}

								if(prox == 1)
									{	
										a.style.color = "navy";
									}

								if(prox == 2)
									{	
										a.style.color = "red";
									}

								if(prox == 3)
									{	
										a.style.color = "purple";
									}

								if(prox == 4)
									{	
										a.style.color = "orange";
									}

								if(prox == 5)
									{	
										a.style.color = "yellow";
									}

								if(prox == 6)
									{	
										a.style.color = "aqua";
									}

								if(prox == 7)
									{	
										a.style.color = "fuchsia";
									}

								if(prox == 8)
									{	
										a.style.color = "maroon";
									}

								if(prox == 9)
									{	
										a.style.color = "olive";
									}

							}
					}

					function start()
						{
							t = setInterval(update, 100);
							submit.disabled = true;
							h = 0;
							m = 0;
							s = 0;
							ms = 0;
							time.innerHTML = h+'h '+m+'min '+s+'sec';
						}

					function update()
						{
							ms += 1;

							if(ms == 10)
								{	
									ms = 1;
									s += 1;
								}

							if(s == 60)
								{	
									s = 0;
									m += 1;
								}

							if(m == 60)
								{	
									m = 0;
									h += 1;
								}

							if(h == 0)
								{	
									time.innerHTML = m+'m '+s+'s';
								}

							else
								{	
									time.innerHTML = h+'h '+m+'min '+s+'sec';
								}
						}

						function stop()
							{
								clearInterval(t);
								submit.disabled = false;
							}


			
		


</script>