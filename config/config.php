<?php
ob_start(); // Démarre la temporisation de sortie
session_start();

$timezone = date_default_timezone_set("Europe/Paris"); // Définit le décalage horaire par défaut de toutes les fonctions date/heure

$con = mysqli_connect("localhost", "root", "", "social_network"); // Connecter la BDD avec PHP

if(mysqli_connect_error()) {
  echo "Failed to connect : " + mysqli_connect_error();
}