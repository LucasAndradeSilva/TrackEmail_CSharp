using Microsoft.Extensions.Configuration;
using Microsoft.IdentityModel.Protocols;
using System;
using System.Collections.Generic;
using System.Configuration;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using TrackEmail.Service;

namespace TrackEmail.Services
{
    public class DBServices : IDBServices
    {
        private string connection;

        public DBServices(string connec)
        {
            connection = connec;
        }

        public string GravarAcesso(string email, string titulo, string date, string nome)
        {
            var con = new SqlConnection(connection);
            var cmd = new SqlCommand("P_GravaAcesso", con) { CommandType = System.Data.CommandType.StoredProcedure };
            cmd.Parameters.AddWithValue("@email", email);
            cmd.Parameters.AddWithValue("@nome", nome);
            cmd.Parameters.AddWithValue("@data", date);            

            try
            {
                con.Open();
                var reader = cmd.ExecuteReader();
                var retorno = reader.Read() ? reader[0].ToString() : string.Empty;
                return retorno;
            }
            catch (Exception exe)
            {
                return "";
            }
            finally
            {
                con.Close();
                cmd.Dispose();
            }
        }
    }
}