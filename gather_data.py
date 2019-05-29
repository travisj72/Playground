import sys
from datetime import date, datetime
import mysql.connector
import pymssql
import smtplib
import timeit
import logging
from TimedRotatingLogs import SizedTimedRotatingFileHandler

def connect_local_db(logger, subject, receivers):
    """ Connects to the local MySQL servers, creates the database and releases table if they don't exist
    Args: None
    Returns: mysql_connection
    """

    DB_NAME = "dataplayground"
    db_ip = "localhost"
    db_user = "root"
    db_pass = "placeholder"
    try:
        connection = mysql.connector.connect(host=db_ip, user=db_user, password=db_pass)
    except ValueError:
        logger.error("Can not connect to the playground")
        message = "Can not connect to the playground"
        utils.send_email(subject,message, receivers)
        sys.exit("Can not connect to the playground")
    # Set db to newly created one
    # If fails create database
    try:
        logger.info("Connecting to database {0}".format(DB_NAME))
        connection.database = DB_NAME
    except mysql.connector.Error:
        logger.debug("Database not found, creating database...")
        cursor = connection.cursor()
        cursor.execute("CREATE DATABASE {} DEFAULT CHARACTER SET 'utf8'".format(DB_NAME))
        connection.database = DB_NAME
    cursor = connection.cursor()

    # Create checker health table if it doesn't exist
    cursor.execute((
        "CREATE TABLE IF NOT EXISTS PlayGround ("
        "  FName VARCHAR (50) NOT NULL, "
        "  LName VARCHAR (50) NOT NULL, "
        "  Date VARCHAR (255) NOT NULL, "
        "  ID VARCHAR (255) NOT NULL, "
        "  Color VARCHAR (255) NOT NULL, "
        "  Car VARCHAR (255) NOT NULL, "
        "  City VARCHAR(255) NOT NULL, "
        "  State VARCHAR (255) NOT NULL "
        ") ENGINE=InnoDB")
    )

    cursor.close()
    return connection


def copy_checker_status(mysql_connection, logger, subject, receivers):
    mysql_cursor = mysql_connection.cursor()

   

    cursor = mysql_connection.cursor()
    # Query data from PhoneHomeUpgrade database that is newer than 3 days
    cursor.execute("""  SELECT * From PlayGround """)

    phone_home_data = cursor.fetchall()
    add_cs = ("INSERT INTO PlayGround "
              "(FName, LName, Date, ID, Color, Car, City, State)"
              "VALUES ( %s, %s, %s, %s, %s, %s, %s, %s)")

    # Insert data retrieved from PH into Mysql
    count = 0
    errcount = 0
    MAX_ERRORS = 10
    for row in phone_home_data:
        first_name = row[0]
        last_name = row[1]
        date = row[2]
        ID = row[3]
        color = row[4]
        car = row[5]
        city = row[6]
        state = row[7]
        try:
            mysql_cursor.execute(add_cs, (first_name, last_name, date, ID, color, car, city, state,))
            count = count + 1
            # Comitting as we go so in case of error we don't lose all progress
            if count > 0 and count % 1000 == 0:
                mysql_connection.commit()

        except mysql.connector.Error as err:
            errcount = errcount + 1
            logger.warn("Error inserting row: {}".format(err))
            if errcount >= MAX_ERRORS:
                logger.error("Maximum error count of {0} reached, aborting".format(MAX_ERRORS))
                message = "Maximum error count of {0} reached, aborting".format(MAX_ERRORS)
                utils.send_email(subject,message, receivers)
                sys.exit("Maximum error count of {0} reached, aborting".format(MAX_ERRORS))
    logger.info("Total # of errors inserting rows: {0}".format(errcount))
    # Close our cursors
    cursor.close()
    mysql_cursor.close()

    # Commit our transacttion so that it sticks around
    mysql_connection.commit()

    logger.info("{0} checker health rows inserted".format(count))

    return


def connections(env, logger, subject,receivers):
    logger.debug("Loading local environment... ")

    # MySQL database connection
    try:
        mysql_connection = connect_local_db(logger, subject,receivers)
    except ValueError:
        logger.error("Can not connect to the playground")

    # Insert data into mysql database
    copy_checker_status(mysql_connection, logger, subject, receivers)

    mysql_connection.close()


def main():
    """Sets up connections to local MySQL db and IM db and calls functions to
        compare release versions and update local MySQL db
    Returns: None
    """
    start = timeit.default_timer()
    log_filename = '/var/log/data_pull.log'
    doc = 'Gathering Data'
    logger = SizedTimedRotatingFileHandler.getLogger(doc)
    logger.setLevel(logging.INFO)
    handler = SizedTimedRotatingFileHandler(
        log_filename, maxBytes=10000000, backupCount=2,  # 10MB max Bytes
        when='w3',
    )
    logger.addHandler(handler)
    today = datetime.today
    logger.info("-------------------------------------")
    logger.info("New log on {0}".format(today()))

    # Setting up email basic settings
    subject = "Python Script Failure"
    receivers = ["tjnospam@gmail.com"]

    argerror = False

    if len(sys.argv) != 2:
        argerror = True

    if argerror:
        logger.error("Usage: {0} no arguement".format(sys.argv[0]))
        message = "Usage: {0} no arguement".format(sys.argv[0])
        utils.send_email(subject,message, receivers)
        sys.exit('Invalid Argument')

    connections( logger, subject,receivers)

    logger.info("Connections closed\n")

    stop = timeit.default_timer()
    total_time = stop - start
    time = datetime.now()

    # output running time in a nice format.
    mins, secs = divmod(total_time, 60)

    logger.info("Run ended: {0}".format(time))
    logger.info("Total running time: {0} minute(s), {1:.2f} second(s)\n".format(mins, secs))


if __name__ == '__main__':
    main()

