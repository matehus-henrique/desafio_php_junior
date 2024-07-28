import mysql.connector
import pandas as pd
import time
def connect_to_db():
    return mysql.connector.connect(
        host="desafio-tecnico.cf1afo0ns4vr.us-west-2.rds.amazonaws.com",
        user="matheus_henrique",
        password="DesafioAvant@2024",
        database="matheus_henrique"
    )


def fetch_data_from_db(conn):
    queries = {
        'Reservations': """
            SELECT reservations.id, reservations.start_time, reservations.end_time,
                   users.name AS user_name, rooms.name AS room_name
            FROM reservations
            JOIN users ON reservations.user_id = users.id
            JOIN rooms ON reservations.room_id = rooms.id
        """
    }
    
    dfs = {}
    for sheet_name, query in queries.items():
        df = pd.read_sql(query, conn)
        dfs[sheet_name] = df
    
    return dfs


def generate_excel_report(dataframes, output_path):
    with pd.ExcelWriter(output_path, engine='openpyxl') as writer:
        for sheet_name, df in dataframes.items():
            df.to_excel(writer, index=False, sheet_name=sheet_name)
    print(f"Relatório gerado com sucesso em {output_path}")

def main():
    conn = connect_to_db()
    try:
        dataframes = fetch_data_from_db(conn)
        generate_excel_report(dataframes, "relatorio.xlsx")
    finally:
        conn.close()

if __name__ == "__main__":
    main()
