from datetime import date
import json

class Hotel:
    def __init__(self):
        self.rooms = {}
        self.available_rooms = {'std':[101,102,103], 'delux':[201,202,203], 'execu':[301,302,303], 'suite':[401,402,403]}
        self.roomprice = {1:308, 2:340, 3:400, 4:900}
        self.load_data()

    def save_data(self):
        data = {
            'rooms': self.rooms,
            'available_rooms': self.available_rooms
        }
        with open('Learning/Mini Project/hotel_data.txt', 'w') as file:
            json.dump(data, file)

    def load_data(self):
        try:
            with open('Learning/Mini Project/hotel_data.txt', 'r') as file:
                data = json.load(file)
                self.rooms = {int(k): v for k, v in data['rooms'].items()}
                self.available_rooms = data['available_rooms']
        except FileNotFoundError:
            pass

    def check_in(self, name, address, phone):
        try:
            roomtype = int(input("\nRoom types: \n1. Quad Room \n2. Sixer Room \n3. King Room \n4. Theme Park Hotel Suite \n\nSelect a room type: "))

            if roomtype == 1:
                if self.available_rooms['std']:
                    room_no = self.available_rooms['std'].pop(0)
                else:
                    print("Sorry, Standard room not available")
                    return
            
            elif roomtype == 2:
                if self.available_rooms['delux']:
                    room_no = self.available_rooms['delux'].pop(0)
                else:
                    print("Sorry, Deluxe room not available")
                    return
                
            elif roomtype == 3:
                if self.available_rooms['execu']:
                    room_no = self.available_rooms['execu'].pop(0)
                else:
                    print("Sorry, Executive room not available")
                    return
                
            elif roomtype == 4:
                if self.available_rooms['suite']:
                    room_no = self.available_rooms['suite'].pop(0)
                else:
                    print("Sorry, Suite room not available")
                    return
            
            else:
                print("Choose a valid room type")
                return

            d, m, y = map(int, input("Enter check-in date in day-month-year format: ").split())

            try:
                check_in = date(y, m, d)
            except ValueError:
                print("Invalid date format. Please enter in day-month-year format.")
                return

            self.rooms[room_no] = {
                'name': name,
                'address': address,
                'phone': phone,
                'check_in_date': check_in.strftime('%Y-%m-%d'),
                'room_type': roomtype,
                'roomservice': 0
            }

            self.save_data()
            print(f"\n~ - ~ - Checked in {name}, {address}, to room: {room_no} on {check_in} ~ - ~ -")

        except ValueError:
            print("Invalid choice. Please try again. ")


    def room_service(self, room_no):
        if room_no in self.rooms:
            print("\n***** Genting Restaurant Menu *****")
            print("1. Tea/Coffee: RM 10 \t2. Dessert: RM 20 \t3. Breakfast: RM 50 \t4. Lunch: RM 80 \t5. Dinner: RM 120 \t6. Exit")

            while True:
                c = int(input("Select your choice: "))
                
                if c == 1:
                    q = int(input("Enter the quantity: "))
                    self.rooms[room_no]['roomservice'] += 10 * q
                
                elif c == 2:
                    q = int(input("Enter the quantity: "))
                    self.rooms[room_no]['roomservice'] += 20 * q
                
                elif c == 3:
                    q = int(input("Enter the quantity: "))
                    self.rooms[room_no]['roomservice'] += 50 * q

                elif c == 4:
                    q = int(input("Enter the quantity: "))
                    self.rooms[room_no]['roomservice'] += 80 * q

                elif c == 5:
                    q = int(input("Enter the quantity: "))
                    self.rooms[room_no]['roomservice'] += 120 * q

                elif c == 6:
                    break

                else:
                    print("Invalid option")

            self.save_data()
            print("Room Service RM:", self.rooms[room_no]['roomservice'], "\n")

        else:
            print("Not occupied /Invalid room number")


    def display_occupied(self):
        while True:
            print("\nOptions:")
            print("1. View Occupied Rooms")
            print("2. Search Room")
            print("3. Edit Room Details")
            print("4. Back to Main Menu")

            choice = input("\nEnter your choice (1-4): ")

            if choice == "1":
                self.show_occupied_rooms()
            elif choice == "2":
                self.search_room()
            elif choice == "3":
                self.edit_room()
            elif choice == "4":
                break
            else:
                print("Invalid choice. Please try again.")

    def show_occupied_rooms(self):
        if not self.rooms:
            print("\nNo rooms are occupied at the moment.")
        else:
            print("\nOccupied Rooms: ")
            print("--------------------------")
            print('Room no.     Name    Phone')
            print("--------------------------")

            for room_number, details in self.rooms.items():
                print(room_number, '\t', details['name'], '\t', details['phone'])

    def search_room(self):
        search_room_no = int(input("Enter room number to search: "))
        if search_room_no in self.rooms:
            details = self.rooms[search_room_no]
            print(f"\nRoom No: {search_room_no}")
            print(f"Name: {details['name']}")
            print(f"Address: {details['address']}")
            print(f"Phone: {details['phone']}")
            print(f"Check-in Date: {details['check_in_date']}")
            print(f"Room Type: {details['room_type']}")
            print(f"Room Service: {details['roomservice']}")
        else:
            print(f"\nRoom {search_room_no} is not occupied.")

    def edit_room(self):
        edit_room_no = int(input("Enter room number to edit: "))
        if edit_room_no in self.rooms:
            details = self.rooms[edit_room_no]
            print("\nEditing Room Details (leave blank to keep current value):")
            name = input(f"Name ({details['name']}): ")
            address = input(f"Address ({details['address']}): ")
            phone = input(f"Phone ({details['phone']}): ")
            if name:
                details['name'] = name
            if address:
                details['address'] = address
            if phone:
                details['phone'] = phone
            self.save_data()
            print(f"\n~ ~ ~ ~ ~ Room {edit_room_no} details updated. ~ ~ ~ ~ ~")
        else:
            print(f"\nRoom {edit_room_no} is not occupied.")

    def check_out(self, room_number):
        if room_number in self.rooms:
            check_out_date = date.today()
            check_in_date = date.fromisoformat(self.rooms[room_number]['check_in_date'])
            duration = (check_out_date - check_in_date).days
            
            roomtype = self.rooms[room_number]['room_type']

            if roomtype == 1:
                self.available_rooms['std'].append(room_number)
            
            elif roomtype == 2:
                self.available_rooms['delux'].append(room_number)

            elif roomtype == 3:
                self.available_rooms['execu'].append(room_number)

            elif roomtype == 4:
                self.available_rooms['suite'].append(room_number)

            print("\n---------------------------------------------------------")
            print("|    Genting Hotel Receipt\t\t\t\t|")
            print("| \t\t\t\t\t\t\t|")
            print(f"|    Name: {self.rooms[room_number]['name']}\t\t\t\t\t|")
            print(f"|    Address: {self.rooms[room_number]['address']}\t\t\t\t|")
            print(f"|    Phone: {self.rooms[room_number]['phone']}\t\t\t\t\t|")
            print(f'|    Room Number: {room_number}\t\t\t\t\t|')
            print(f"|    Check-In date: {check_in_date.strftime('%d %B %Y')}\t\t\t\t|")
            print(f'|    Check-Out date: {check_out_date.strftime("%d %B %Y")}\t\t\t|')
            print(f"|    No. of Days: {duration}\tPrice per day: RM {self.roomprice[roomtype]}\t\t|")
            print("| \t\t\t\t\t\t\t|")

            roombill = self.roomprice[roomtype] * duration
            roomservice = self.rooms[room_number]['roomservice']

            print('|    Room bill: RM ', roombill,'\t\t\t\t|')
            print('|    Room service: RM ', roomservice,'\t\t\t\t|')
            print('|    Total bill: RM ', roombill + roomservice,'\t\t\t\t|')
            print("---------------------------------------------------------")

            del self.rooms[room_number]
            self.save_data()

        else:
            print(f"Room {room_number} is not occupied.")

    def start_app(self):
        while True:
            print("\n---------------------------------------------")
            print("Welcome To Genting Skyworld Hotel Reservation")
            print("1. Check-In")
            print("2. Room Service")
            print("3. Display Occupied Room")
            print("4. Check-Out")
            print("5. Exit\n")

            choice = input("Enter your choice (1-5): ")

            if choice == "1":
                name = input("\nEnter Client Name: ")
                address = input("Enter Address: ")
                phone = input("Enter Contact No: ")
                self.check_in(name, address, phone)
            
            elif choice == "2":
                try:
                    room_no = int(input("\nEnter the room number: "))
                    self.room_service(room_no)
                
                except ValueError:
                    print("Invalid choice. Please try again. ")
            
            elif choice == "3":
                self.display_occupied()

            elif choice == "4":
                try:
                    room_number = int(input("\nEnter the room number: "))
                    self.check_out(room_number)
                except ValueError:
                    print("Invalid input. Please try again. ")

            elif choice == "5":
                break

            else:
                print("\nInvalid choice. Please try again.")

h = Hotel()
h.start_app()

