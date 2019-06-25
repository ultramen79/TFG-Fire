package com.example.fire;

import android.net.Uri;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v4.app.FragmentTransaction;
import android.view.View;
import android.support.v4.view.GravityCompat;
import android.support.v7.app.ActionBarDrawerToggle;
import android.view.MenuItem;
import android.support.design.widget.NavigationView;
import android.support.v4.widget.DrawerLayout;

import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.widget.Toast;

public class MainActivity extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener,FragmentCamara.Enviardatos, FragmentVehiculos.EnviarMatricula, FragmentConsultar.EnviarConsulta, FragmentEnviarFoto.OnFragmentInteractionListener{

    String textoAPasar, matriculaAPasar,textoAPasarDatos,herramientaAPasar;
    String matricula, herramienta, matricula1, herramienta1;
    //public static final String ip=" https://fire1979.000webhostapp.com/fire/ServicioWeb/json/";
    public static final String ip="http://192.168.0.19/fire/ServicioWeb/json/";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        if (null == savedInstanceState) {
            getSupportFragmentManager().beginTransaction()
                    .replace(R.id.content_main, FragmentVehiculos.newInstance())
                    .commit();
        }

        Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        FloatingActionButton fab = findViewById(R.id.fab);
        fab.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Snackbar.make(view, "Replace with your own action", Snackbar.LENGTH_LONG)
                        .setAction("Action", null).show();
            }
        });
        DrawerLayout drawer = findViewById(R.id.drawer_layout);
        NavigationView navigationView = findViewById(R.id.nav_view);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.addDrawerListener(toggle);
        toggle.syncState();
        navigationView.setNavigationItemSelectedListener(this);
    }

    @Override
    public void onBackPressed() {
        DrawerLayout drawer = findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }
        return super.onOptionsItemSelected(item);
    }

    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        int id = item.getItemId();

        if (id == R.id.nav_home) {
            FragmentTransaction ft = getSupportFragmentManager().beginTransaction();
            ft.replace(R.id.content_main, FragmentVehiculos.newInstance());
            ft.commit();

        } else if (id == R.id.nav_entrada) {

            FragmentTransaction ft = getSupportFragmentManager().beginTransaction();
            if (matricula==null || herramienta==null){
                Toast.makeText(getApplicationContext(),"No se ha producido comunicación",Toast.LENGTH_SHORT).show();
            }
            else {
                Toast.makeText(getApplicationContext(),"Si se ha producido comunicación",Toast.LENGTH_SHORT).show();
                ft.replace(R.id.content_main, FragmentEntrada.newInstance(matricula,herramienta));
            }
            ft.commit();
            ft.addToBackStack(null);

        } else if (id == R.id.nav_salida) {

            FragmentTransaction ft = getSupportFragmentManager().beginTransaction();
            if (matricula==null || herramienta==null){
                Toast.makeText(getApplicationContext(),"No se ha producido comunicación",Toast.LENGTH_SHORT).show();
            }
            else {
                Toast.makeText(getApplicationContext(),"Si se ha producido comunicación",Toast.LENGTH_SHORT).show();
                ft.replace(R.id.content_main, FragmentSalida.newInstance(matricula,herramienta));
            }
            ft.commit();
            ft.addToBackStack(null);

        } else if (id == R.id.nav_consultar) {

            FragmentTransaction ft = getSupportFragmentManager().beginTransaction();
            if (matriculaAPasar == null) {
                Toast.makeText(getApplicationContext(), "No se ha producido comunicación", Toast.LENGTH_SHORT).show();
            } else {
                Toast.makeText(getApplicationContext(), "Si se ha producido comunicación", Toast.LENGTH_SHORT).show();
                ft.replace(R.id.content_main, FragmentConsultar.newInstance(matriculaAPasar));
            }
            ft.commit();
            ft.addToBackStack(null);

        } else if (id == R.id.nav_subir_imagen) {

            FragmentTransaction ft = getSupportFragmentManager().beginTransaction();
            ft.replace(R.id.content_main, FragmentEnviarFoto.newInstance());
            ft.commit();
            ft.addToBackStack(null);

        } else if (id == R.id.nav_tools) {

        } else if (id == R.id.nav_share) {

        } else if (id == R.id.nav_send) {

        }

        DrawerLayout drawer = findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }

    @Override
    public void enviar(String text1, String text2) {
        if (text1==null || text2==null) {
            matricula = "Nada";
            herramienta = "Nada";
        } else {
            matricula = text1;
            herramienta = text2;
        }
    }

    public void setText(String text) {
        textoAPasar=text;
    }

    @Override
    public void enviarma(String texto) {
        matriculaAPasar= texto;
        FragmentTransaction ft = getSupportFragmentManager().beginTransaction();
        if (matriculaAPasar == null) {
            Toast.makeText(getApplicationContext(), "No se ha producido comunicación de seleccion de vehiculo", Toast.LENGTH_SHORT).show();
        } else {
            Toast.makeText(getApplicationContext(), "Ha sido seleccionado un vehiculo", Toast.LENGTH_SHORT).show();
            ft.replace(R.id.content_main, FragmentCamara.newInstance(matriculaAPasar));
            ft.addToBackStack(null);
            ft.commit();
        }
    }

    @Override
    public void enviarcons(String text1, String text2) {
        matricula1= text1;
        herramienta1 = text2;
        FragmentTransaction ft = getSupportFragmentManager().beginTransaction();
        if (matricula1 == null || herramienta1 == null ) {
            Toast.makeText(getApplicationContext(), "No se ha producido la consulta", Toast.LENGTH_SHORT).show();
        } else {
            Toast.makeText(getApplicationContext(), "Consultado... "+ matricula1+ " : "+herramienta1, Toast.LENGTH_SHORT).show();
            ft.replace(R.id.content_main, FragmentRespuestaConsultar.newInstance(matricula1, herramienta1));
            ft.addToBackStack(null);
            ft.commit();
        }
    }

    @Override
    public void onFragmentInteraction(Uri uri) {

    }
}
