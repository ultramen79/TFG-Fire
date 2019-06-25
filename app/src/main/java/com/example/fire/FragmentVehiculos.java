package com.example.fire;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v13.app.FragmentCompat;
import android.support.v4.app.Fragment;
import android.support.v4.content.ContextCompat;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

import static com.example.fire.MainActivity.ip;

public class FragmentVehiculos extends Fragment implements FragmentCompat.OnRequestPermissionsResultCallback,Response.Listener<JSONObject>, Response.ErrorListener {

    private static final int PERMISSIONS_REQUEST_CODE = 1;
    private boolean checkedPermissions = false;

    EnviarMatricula infor;
    TextView textView1, textView2;
    ListView listViewVehiculos;
    List<String> listavehiculos;
    ProgressDialog progreso;
    JsonObjectRequest jsonObjectRequest;
    private View vie;
    public FragmentVehiculos() {
    }

    public static FragmentVehiculos newInstance() {
        FragmentVehiculos fragmento2Dinamico = new FragmentVehiculos();
        return fragmento2Dinamico;
    }

    @Override
    public View onCreateView( LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        vie = getActivity().getLayoutInflater().inflate(R.layout.fragment_vehiculos, container, false);

        textView1 = (TextView) vie.findViewById(R.id.textViewVehiculo1);
        textView2 = (TextView) vie.findViewById(R.id.tv1);
        listViewVehiculos = (ListView) vie.findViewById(R.id.lv1);
        listavehiculos = new ArrayList<>();

        if (1 > listavehiculos.size()) {
            cargarWebService();
        }

        listViewVehiculos.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                String tex= (String) listViewVehiculos.getItemAtPosition(position);
                infor.enviarma (tex);
            }
        });

        return vie;
    }

    @Override
    public void onActivityCreated(Bundle savedInstanceState) {
        super.onActivityCreated(savedInstanceState);
    }

    @Override
    public void onAttach(Context context) {
        super.onAttach(context);
        try{
            infor = (EnviarMatricula) context;
        }
        catch (Exception e){
            Log.v("test", "Error, no se ha podido llevar a cabo la comunicación");
        }
    }

    @Override
    public void onResume() {
        super.onResume();
    }

    @Override
    public void onPause() {
        super.onPause();
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);
    }

    private boolean allPermissionsGranted() {
        for (String permission : getRequiredPermissions()) {
            if (ContextCompat.checkSelfPermission(getActivity(), permission)
                    != PackageManager.PERMISSION_GRANTED) {
                return false;
            }
        }
        return true;
    }

    private String[] getRequiredPermissions() {
        Activity activity = getActivity();
        try {
            PackageInfo info =
                    activity
                            .getPackageManager()
                            .getPackageInfo(activity.getPackageName(), PackageManager.GET_PERMISSIONS);
            String[] ps = info.requestedPermissions;
            if (ps != null && ps.length > 0) {
                return ps;
            } else {
                return new String[0];
            }
        } catch (Exception e) {
            return new String[0];
        }
    }

    private void cargarWebService() {
        RequestQueue request;
        request = Volley.newRequestQueue(getContext());
        progreso = new ProgressDialog (getContext());
        progreso.setMessage("Cargando Lista de Vehiculos.....");
        progreso.show();

        String url= ip+"ConsultaVehiculos.php";
        //url = url.replace(" ","%20");
        jsonObjectRequest = new JsonObjectRequest(Request.Method.GET,url,null,this,this);
        request.add(jsonObjectRequest);
    }

    @Override
    public void onErrorResponse(VolleyError error) {
        progreso.hide();
        Toast.makeText(getContext(),"No se pudo consultar" + error.toString(),Toast.LENGTH_SHORT).show();
        Log.i("ERROR ", error.toString());
    }

    @Override
    public void onResponse(JSONObject response) {
        progreso.hide();
        String matri="";
        JSONArray json=response.optJSONArray("datos");
        try {
            for (int i=0;i<json.length();i++){
                JSONObject jsonObject=null;
                jsonObject=json.getJSONObject(i);
                matri=(String) jsonObject.optString("ma_nu");
                listavehiculos.add(matri);
            }
            progreso.hide();
            ArrayAdapter adaptor = new ArrayAdapter(this.getContext(),R.layout.list_item_matriculas , listavehiculos);
            listViewVehiculos.setAdapter(adaptor);

        } catch (JSONException e) {
            e.printStackTrace();
            Toast.makeText(getContext(), "No se ha podido establecer conexión con el servidor" +
                    " "+response, Toast.LENGTH_LONG).show();
            progreso.hide();
        }

    }

    public interface EnviarMatricula {
        public void enviarma(String texto);
    }

    @Override
    public void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        if (!checkedPermissions && !allPermissionsGranted()) {
            Context con = null;
            requestPermissions(getRequiredPermissions(), PERMISSIONS_REQUEST_CODE);
            return;
        } else {
            checkedPermissions = true;
        }
    }
}